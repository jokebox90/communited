<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FrontController extends AbstractController
{
    #[Route("/", methods: ["GET"], name: "app:front")]
    #[Route("/{path<.+>}", methods: ["GET"], name: "app:site")]
    public function index(): Response
    {
        return $this->render("front.html.twig");
    }

    #[Route("/admin/{path<.+>}", methods: ["GET"], name: "app:admin", priority: 99)]
    public function secured(): Response
    {
        if (!$this->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            return $this->redirect("/sign-in");
        }

        return $this->render("front.html.twig");
    }
}
