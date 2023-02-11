<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route("/about", name: "app:about")]
    #[Route("/about/{name<[a-zA-z0-9]+>}", name: "app:about:with-name")]
    public function index($name = ""): Response
    {
        return $this->render("about.html.twig", [
            "name" => $name,
            "message" => "Welcome to your new controller!",
            "path" => "src/Controller/AboutController.php",
        ]);
    }
}
