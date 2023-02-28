<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
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
#[IsGranted("ROLE_ADMIN")]
#[Route("/api/shop/customers", priority: 999)]
class CustomerController extends AbstractController
{
    #[Route("/", name: "app:shop:customers")]
    public function customerList(CustomerRepository $repository): Response
    {
        $results = new ArrayCollection($repository->findAll());
        $jsonData = $results->map(function(Customer $customer) {
            return $customer->populateArray();
        });

        return new JsonResponse([
            "customers" => $jsonData->toArray(),
        ], Response::HTTP_OK);
    }

    #[Route("/{customerId<[a-f0-9-]{36}>}", name: "app:shop:customer:read")]
    public function customerRead(string $customerId, CustomerRepository $repository): Response
    {
        $customer = $repository->find($customerId);
        $jsonData = $customer->populateArray();

        return new JsonResponse([
            "customer" => $jsonData,
        ], Response::HTTP_OK);
    }
}
