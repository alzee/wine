<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Org;
use App\Entity\Product;
use App\Entity\Orders;
use App\Entity\OrderItems;
use Doctrine\Persistence\ManagerRegistry;

class OrderController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/api/order/new', name: 'api_order_new')]
    public function orderNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $seller = $this->doctrine->getRepository(Org::class)->find($params['sellerid']);
        $buyer = $this->doctrine->getRepository(Org::class)->find($params['buyerid']);
        $product = $this->doctrine->getRepository(Product::class)->find($params['product']);
        $quantity = $params['quantity'];
        $em = $this->doctrine->getManager();
        $order = new Orders();
        $order->setSeller($seller);
        $order->setBuyer($buyer);
        $order->setNote($params['note']);
        $em->persist($order);
        $em->flush();

        $items = new OrderItems();
        $items->setProduct($product);
        $items->setQuantity($quantity);
        $items->setOrd($order);
        $em->persist($items);
        
        $order->setAmount($product->getPrice() * $quantity);
        $order->setVoucher($product->getVoucher() * $quantity);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/api/return/new', name: 'api_return_new')]
    public function returnNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $seller = $this->doctrine->getRepository(Org::class)->find($params['sellerid']);
        $buyer = $this->doctrine->getRepository(Org::class)->find($params['buyerid']);
        $product = $this->doctrine->getRepository(Product::class)->find($params['product']);
        $em = $this->doctrine->getManager();
        $order = new Orders();
        $order->setSeller($seller);
        $order->setBuyer($buyer);
        $order->setNote($params['note']);
        $em->persist($order);
        $em->flush();

        $items = new OrderItems();
        $items->setProduct($product);
        $items->setQuantity($params['quantity']);
        $items->setOrd($order);
        $em->persist($items);
        
        $order->setAmount($product->getPrice() * $quantity);
        $order->setVoucher($product->getVoucher() * $quantity);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }
}
