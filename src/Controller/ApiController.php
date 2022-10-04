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
use App\Entity\Returns;
use App\Entity\ReturnItems;
use App\Entity\Retail;
use App\Entity\OrderRestaurant;
use App\Entity\Scan;
use App\Entity\Consumer;
use App\Entity\User;
use App\Entity\RetailReturn;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api')]
class ApiController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/order/new', methods: ['POST'])]
    public function orderNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $seller = $this->doctrine->getRepository(Org::class)->find($params['sellerid']);
        $buyer = $this->doctrine->getRepository(Org::class)->find($params['buyerid']);
        $product = $this->doctrine->getRepository(Product::class)->find($params['product']);
        $quantity = $params['quantity'];
        $em = $this->doctrine->getManager();

        $item = new OrderItems();
        $item->setProduct($product);
        $item->setQuantity($quantity);
        $em->persist($item);
        $em->flush();

        $order = new Orders();
        $order->setSeller($seller);
        $order->setBuyer($buyer);
        $order->setNote($params['note']);
        $order->addOrderItem($item);

        $em->persist($order);
        $em->flush();
        
        $item->setOrd($order);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/return/new', methods: ['POST'])]
    public function returnNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $sender = $this->doctrine->getRepository(Org::class)->find($params['senderid']);
        $recipient = $this->doctrine->getRepository(Org::class)->find($params['recipientid']);
        $product = $this->doctrine->getRepository(Product::class)->find($params['product']);
        $quantity = $params['quantity'];
        $em = $this->doctrine->getManager();

        $item = new ReturnItems();
        $item->setProduct($product);
        $item->setQuantity($quantity);
        $em->persist($item);
        $em->flush();

        $ret = new Returns();
        $ret->setSender($sender);
        $ret->setRecipient($recipient);
        $ret->setNote($params['note']);
        $ret->addReturnItem($item);

        $em->persist($ret);
        $em->flush();

        $item->setRet($ret);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/retail/new', methods: ['POST'])]
    public function retailNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $store = $this->doctrine->getRepository(Org::class)->find($params['oid']);
        $consumer = $this->doctrine->getRepository(Consumer::class)->find($params['cid']);
        $product = $this->doctrine->getRepository(Product::class)->find($params['pid']);
        $rand = $params['timestamp'];
        $quantity = $params['quantity'];
        $em = $this->doctrine->getManager();

        $retail = new Retail();
        $retail->setStore($store);
        $retail->setConsumer($consumer);
        $retail->setProduct($product);
        $retail->setQuantity($quantity);
        $em->persist($retail);

        $scan = new Scan();
        $scan->setConsumer($consumer);
        $scan->setOrg($store);
        $scan->setRand($rand);
        $em->persist($scan);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/dine/new', methods: ['POST'])]
    public function dineNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $restaurant = $this->doctrine->getRepository(Org::class)->find($params['oid']);
        $consumer = $this->doctrine->getRepository(Consumer::class)->find($params['cid']);
        $rand = $params['timestamp'];
        $voucher = $params['voucher'];
        $em = $this->doctrine->getManager();

        $dine = new OrderRestaurant();
        $dine->setRestaurant($restaurant);
        $dine->setConsumer($consumer);
        $dine->setVoucher($voucher);
        $em->persist($dine);

        $scan = new Scan();
        $scan->setConsumer($consumer);
        $scan->setOrg($restaurant);
        $scan->setRand($rand);
        $em->persist($scan);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/retail_return/new', methods: ['POST'])]
    public function retailReturnNew(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $store = $this->doctrine->getRepository(Org::class)->find($params['oid']);
        $consumer = $this->doctrine->getRepository(Consumer::class)->find($params['cid']);
        $product = $this->doctrine->getRepository(Product::class)->find($params['pid']);
        $rand = $params['timestamp'];
        $quantity = $params['quantity'];
        $em = $this->doctrine->getManager();

        $ret = new RetailReturn();
        $ret->setStore($store);
        $ret->setConsumer($consumer);
        $ret->setProduct($product);
        $ret->setQuantity($quantity);
        $em->persist($ret);

        $scan = new Scan();
        $scan->setConsumer($consumer);
        $scan->setOrg($store);
        $scan->setRand($rand);
        $em->persist($scan);

        $em->flush();

        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/chpwd', methods: ['POST'])]
    public function chpwd(Request $request, UserPasswordHasherInterface $hasher): JsonResponse
    {
        $params  = $request->toArray();
        $user = $this->doctrine->getRepository(User::class)->find($params['uid']);
        $oldPass = $params['oldPass'];
        $plainPassword = $params['plainPassword'];
        $em = $this->doctrine->getManager();

        // if oldPass is right
        if ($hasher->isPasswordValid($user, $oldPass)) {
            $user->setPlainPassword($plainPassword);
            $em->flush();
            $code = 0;
        } else {
            $code = 1;
        }

        return $this->json([
            'code' => $code,
        ]);
    }
}
