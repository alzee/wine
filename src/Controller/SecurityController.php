<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Consumer;
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
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $resp = [
                "code" => 1
            ];
            dump($resp);
        } else {
            $user = $this->getUser();
            $uid = $user->getId();
            $role = $user->getOrg()->getType();
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
    public function consumerLogin(Request $request)
    {
        $data = json_decode($request->getContent());
        $code = $data->code;
        $openid = $this->wx->getOpenid($code);

        $consumer = $this->doctrine->getRepository(Consumer::class)->findOneBy(['openid' => $openid]);
        if (is_null($consumer)) {
            // create
            $em = $this->doctrine->getManager();
            $consumer = new Consumer();
            $consumer->setOpenid($openid);
            $consumer->setName(substr($openid, 0, 8));
            if (isset($data->referrerId)) {
                $referrer = $this->doctrine->getRepository(Consumer::class)->find($data->referrerId);
                if ($referrer) {
                    $consumer->setReferrer($referrer);
                }
            }
            $em->persist($consumer);
            $em->flush();
        }

        $resp = [
            "cid" => $consumer->getId(),
            "role" => 4,
            "name" => $consumer->getName(),
            "phone" => $consumer->getPhone(),
            "voucher" => $consumer->getVoucher(),
            "avatar" => $consumer->getAvatar(),
        ];
        return $this->json($resp);
    }
}
