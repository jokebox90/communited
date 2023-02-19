<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route("/", name: "app:front")]
    #[Route("/{path<.+>}", name: "app:sign-up")]
    public function index(): Response
    {
        return $this->render("front.html.twig");
    }
}
