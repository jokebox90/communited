<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\UniqueIdGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * @property UrlGeneratorInterface $urlGenerator
 * @method   User|null             getUser
 */
#[Route(null, priority: 999)]
class UserController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/api/sign-up', methods: ["POST"], name: 'app:sign-up')]
    public function signUp(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        UniqueIdGenerator $uuid
    ): Response {
        $postData = $request->toArray();

        $username  = $postData['username'];
        $password  = $postData['password'];
        $email     = $postData['email'];
        $approvals = (bool) $postData['approvals'];

        $session = $request->getSession();
        $attempts = (int) $session->get('sign_up_attempts', 0);
        $attempts++;
        $session->set('sign_up_attempts', $attempts);

        if (!$approvals) {
            return new JsonResponse([
                "messages" => ["CGU non acceptées"],
                "attempts" => $attempts,
            ], 400);
        }

        $user = new User();
        $user->setUniqueId($uuid->create());
        $user->setUsername($username);
        $user->setEmail($email);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $messages = [];
            for ($i = 0; $i < count($errors); $i++) {
                $messages[] = $errors[$i]->getMessage();
            }

            return new JsonResponse([
                "messages" => $messages,
            ], 400);
        }

        // encode the plain password
        $user->setPassword(
            $userPasswordHasher->hashPassword($user, $password)
        );

        $count = $entityManager->getRepository(User::class)->countAll();
        if ($count === 0) {
            $user->setRoles(["ROLE_ADMIN"]);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation('app:verify:email', $user,
            (new TemplatedEmail())
                ->from(new Address('mailer@petitboutde.cloud', 'Mail Service'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('signup/confirmation_email.html.twig')
        );

        return new JsonResponse([
            "next" => $this->generateUrl('app:front')
        ], 201);
    }

    #[Route('/verify/email', name: 'app:verify:email')]
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app:front');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app:front');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app:front');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app:front');
    }

    #[Route('/api/sign-in', methods: ["POST"], name: 'app:sign-in')]
    public function sighIn(#[CurrentUser]$user = null): Response
    {
        if (!$user) {
            return new JsonResponse([
                "message" => "Missing credentials.",
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            "username" => $user->getUserIdentifier(),
            "roles"    => $user->getRoles(),
        ], Response::HTTP_OK);
    }

    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/api/sign-out', methods: ["GET"], name: 'app:sign-out')]
    public function signOut(Security $security, UrlGeneratorInterface $urlGenerator): Response
    {
        $security->logout(false);
        return new JsonResponse([
            "message" => "Succesfully sign-out.",
            "nextUrl" => $urlGenerator->generate("app:front"),
        ], Response::HTTP_OK);
    }

    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    #[Route('/api/sign-check', methods: ["GET"], name: 'app:sign-check')]
    public function signCheck(): Response
    {
        $user = $this->getUser();
        return new JsonResponse([
            "message" => "Connected.",
            "user" => [
                "username"  => $user->getUserName(),
                "roles" => $user->getRoles(),
            ],
        ], Response::HTTP_OK);
    }

    /**
     * @var User $user
     */
    #[Route('/api/my-account', name: 'app:my-account')]
    public function myAccount(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse([
                "message" => "Access denied.",
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            "userName"  => $user->getUserName(),
            "userEmail" => $user->getEmail(),
        ], Response::HTTP_OK);
    }

    /**
     * @var User $user
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/api/users', name: 'app:users:list')]
    public function userList(UserRepository $repository): Response
    {
        $results = new ArrayCollection($repository->findAll());
        $jsonData = $results->map(function(User $user) {
            return [
                "userId"    => $user->getUniqueId(),
                "userName"  => $user->getUsername(),
                "userEmail" => $user->getEmail(),
            ];
        });

        return new JsonResponse([
            "users" => $jsonData->toArray(),
        ], Response::HTTP_OK);
    }
}
