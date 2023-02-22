<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @property UrlGeneratorInterface $urlGenerator
 * @method   User|null             getUser
 */
#[IsGranted('ROLE_ADMIN')]
class ItemController extends AbstractController
{
    #[Route('/api/shop/items', name: 'app:shop:items')]
    public function itemList(ItemRepository $repository): Response
    {
        $results = new ArrayCollection($repository->findAll());
        $jsonData = $results->map(function(Item $item) {
            return [
                "itemId"    => $item->getUniqueId(),
                "title"     => $item->getTitle(),
                "available" => $item->getAvailable(),
                "tags"      => $item->getTags(),
            ];
        });

        return new JsonResponse([
            "shopItems" => $jsonData->toArray(),
        ], Response::HTTP_OK);
    }

    #[Route('/api/shop/items/{itemId<[a-f0-9-]{36}>}', name: 'app:shop:item:read')]
    public function itemRead(string $itemId, ItemRepository $repository): Response
    {
        $item = $repository->find($itemId);
        $jsonData = [
            "itemId"      => $item->getUniqueId(),
            "title"       => $item->getTitle(),
            "description" => $item->getDescription(),
            "available"   => $item->getAvailable(),
            "tags"        => $item->getTags(),
            "createdAt"   => $item->getCreatedAt()->format(DateTime::ATOM),
            "modifiedAt"  => $item->getModifiedAt()->format(DateTime::ATOM),
        ];

        return new JsonResponse([
            "shopItem" => $jsonData,
        ], Response::HTTP_OK);
    }
}
