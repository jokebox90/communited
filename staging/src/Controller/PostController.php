<?php

namespace App\Controller;

use App\Entity\Post;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/posts")]
class PostController extends AbstractController
{
    private ManagerRegistry|null $doctrine = null;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }

    #[Route("/", name: "app:posts:index", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repository->findAll();

        return $this->json($posts);
    }

    #[Route("/", name: "app:posts:create", methods: ["PUT"])]
    public function create(Request $request): JsonResponse
    {
        $post = new Post();
        $post->setTitle($request->request->get("title"));
        $post->setContent($request->request->get("content"));

        $categoryIds = $request->request->get("categories");
        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy([
            "uniqueId" => $categoryIds,
        ]);

        for ($i = 0; $i < count($categories); $i++) {
            $post->addCategory($categories[$i]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->json($post);
    }

    #[Route("/{uniqueId}", name: "app:posts:read", methods: ["GET"])]
    public function read(string $uniqueId): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $post = $repository->find($uniqueId);

        return $this->json($post);
    }

    #[Route("/{uniqueId}/edit", name: "app:posts:edit", methods: ["PATCH"])]
    public function update(Request $request, string $uniqueId): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($uniqueId);

        if (!$post) {
            throw $this->createNotFoundException(
                "No post found for id " . $uniqueId
            );
        }

        $post->setTitle($request->request->get("title"));
        $post->setContent($request->request->get("content"));
        $post->setUpdatedAt(new DateTime());

        $categoryIds = $request->request->get("categories");
        $categories = $this->getDoctrine()->getRepository(Category::class)->findBy([
            "uniqueId" => $categoryIds,
        ]);

        for ($i = 0; $i < count($categories); $i++) {
            $category = $categories[$i];
            $post->addCategory($category);
        }

        $entityManager->flush();

        return $this->json($post);
    }

    #[Route("/{uniqueId}", name: "app:posts:delete", methods: ["DELETE"])]
    public function delete(string $uniqueId): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($uniqueId);

        if (!$post) {
            throw $this->createNotFoundException(
                "No post found for id " . $uniqueId
            );
        }

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->json(["message" => "Post deleted"]);
    }
}
