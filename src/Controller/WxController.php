<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Wx;

#[Route('/wx')]
class WxController extends AbstractController
{
    private $wx;
    
    public function __construct(Wx $wx)
    {
        $this->wx = $wx;
    }
    
    #[Route('.cu', name: 'wx_claim_user')]
    public function cu(): Response
    {
        $scheme = $this->wx->genScheme('myClaim', 'type=user');
        return $this->render('wx/index.html.twig', [
            'scheme' => $scheme,
        ]);
    }
    
    #[Route('.cs', name: 'wx_claim_store')]
    public function cs(): Response
    {
        $scheme = $this->wx->genScheme('myClaim', 'type=user');
        return $this->render('wx/index.html.twig', [
            'scheme' => $scheme,
        ]);
    }
}
