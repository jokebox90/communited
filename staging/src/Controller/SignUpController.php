<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\UniqueIdGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class SignUpController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/api/sign-up', methods: ["POST"], name: 'app:sign-up:check')]
    public function register(
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
            "next" => $this->generateUrl('app:home')
        ], 201);
    }

    #[Route('/verify/email', name: 'app:verify:email')]
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app:sign-up');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app:sign-up');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app:sign-up');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app:sign-up');
    }
}
