<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use App\Service\Wx;

class SecurityController extends AbstractDashboardController
{
    private $doctrine;
    private $wx;

    public function __construct(ManagerRegistry $doctrine, Wx $wx)
    {
        $this->doctrine = $doctrine;
        $this->wx = $wx;
    }

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
        if (! $this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $resp = [
                "code" => 1
            ];
        } else {
            $user = $this->getUser();
            $uid = $user->getId();
            $role = $user->getOrg()->getType();
            $username = $user->getUsername();
            $org = $user->getOrg();
            $data = [
                "uid" => $uid,
                "role" => $role,
                "roles" => $user->getRoles(),
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

    #[Route(path: '/api/wxlogin', name: 'api_wx_login', methods: ['POST'])]
    public function wxLogin(Request $request)
    {
        $data = json_decode($request->getContent());
        $code = $data->code;
        $openid = $this->wx->getOpenid($code);

        $user = $this->doctrine->getRepository(User::class)->findOneBy(['openid' => $openid]);
        $em = $this->doctrine->getManager();
        if (is_null($user)) {
            // create
            $user = new User();
            $user->setOpenid($openid);
            if (isset($data->referrerId)) {
                $referrer = $this->doctrine->getRepository(User::class)->find($data->referrerId);
                if ($referrer) {
                    $user->setReferrer($referrer);
                }
            }
            $em->persist($user);
            $em->flush();
        }
        
        if ($user->isReloginRequired()) {
            $user->setReloginRequired(false);
            $em->flush();
        }

        $resp = [
            "id" => $user->getId(),
            "roles" => $user->getRoles(),
            "name" => $user->getName(),
            "phone" => $user->getPhone(),
            "org" => $user->getOrg()
        ];
        return $this->json($resp);
    }
}
