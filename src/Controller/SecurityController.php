<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin()
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            $resp = [
                "code" => 1
            ];
        }
        else {
            $user = $this->getUser();
            $uid = $user->getId();
            $role = $user->getRoles();
            $username = $user->getUsername();
            $org = $user->getOrg();
            $data = [
                "uid" => $uid,
                "role" => $role,
                "username" => $username,
                "org" => $org
            ];
            $resp = [
                "code" => 0,
                "data" => $data
            ];
        }
        return $this->json($resp);
    }

    #[Route(path: '/api/consumer_login', name: 'api_consumer_login', methods: ['POST'])]
    public function consumerLogin()
    {
    }
}
