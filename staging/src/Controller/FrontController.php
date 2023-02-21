<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route("/", name: "app:front")]
    #[Route("/site/{path<.+>}", name: "app:site")]
    #[Route("/admin/{path<.+>}", name: "app:admin")]
    public function index(): Response
    {
        return $this->render("front.html.twig");
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route("/admin/{path<.+>}", name: "app:admin")]
    public function secured(): Response
    {
        return $this->render("front.html.twig");
    }
}
