<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Consumer;
use Doctrine\Persistence\ManagerRegistry;

class SecurityController extends AbstractController
{
    private $doctrine;
    private $client;

    public function __construct(ManagerRegistry $doctrine, HttpClientInterface $client)
    {
        $this->httpclient = $client;
        $this->doctrine = $doctrine;
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
        $appid = $_ENV['WX_APP_ID'];
        $secret = $_ENV['WX_APP_SECRET'];
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept:application/json';
        $content = $this->httpclient->request('GET', $url ,['headers' => $header])->toArray();
        $sessionKey = $content['session_key'];
        $openid = $content['openid'];

        $consumer = $this->doctrine->getRepository(Consumer::class)->findOneBy(['openid' => $openid]);
        if (is_null($consumer)) {
            // create
            $em = $this->doctrine->getManager();
            $consumer = new Consumer();
            $consumer->setOpenid($openid);
            $em->persist($consumer);
            $em->flush();
        }

        $resp = [
            // "uid" => $consumer->getId(),
            "role" => 4,
            "voucher" => $consumer->getVoucher()
        ];
        return $this->json($resp);
    }
}
