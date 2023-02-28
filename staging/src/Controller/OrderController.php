<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Sold;
use App\Repository\OrderRepository;
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
#[Route(null, priority: 999)]
class OrderController extends AbstractController
{
    #[Route('/api/shop/orders', name: 'app:shop:orders')]
    public function orderList(OrderRepository $repository): Response
    {
        $results = new ArrayCollection($repository->findAll());
        $jsonData = $results->map(function(Order $order) {
            return [
                "orderId"      => $order->getUniqueId(),
                "reference"    => $order->getReference(),
                "emailAddress" => $order->getEmailAddress(),
                "status"       => $order->getStatus(),
                "createdAt"   => $order->getCreatedAt()->format(DateTime::ATOM),
                "modifiedAt"  => $order->getModifiedAt()->format(DateTime::ATOM),
            ];
        });

        return new JsonResponse([
            "orders" => $jsonData->toArray(),
        ], Response::HTTP_OK);
    }

    #[Route('/api/shop/orders/{orderId<[a-f0-9-]{36}>}', name: 'app:shop:order:read')]
    public function orderRead(string $orderId, OrderRepository $repository): Response
    {
        $order = $repository->find($orderId);
        $jsonData = [
            "orderId"      => $order->getUniqueId(),
            "reference"    => $order->getReference(),
            "emailAddress" => $order->getEmailAddress(),
            "status"       => $order->getStatus(),
            "createdAt"    => $order->getCreatedAt()->format(DateTime::ATOM),
            "modifiedAt"   => $order->getModifiedAt()->format(DateTime::ATOM),
        ];

        $items = $order->getSoldItems()->map(function(Sold $sold) {
            return [
                "price" => $sold->getPrice()->populateArray(),
                "item" => $sold->getPrice()->getItem()->populateArray(),
            ];
        });

        $jsonData["items"] = $items->toArray();

        return new JsonResponse([
            "order" => $jsonData,
        ], Response::HTTP_OK);
    }
}
