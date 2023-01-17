<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Org;
use App\Entity\Product;
use App\Entity\Stock;
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
use App\Service\Sms;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

    #[Route('/resetpwd', methods: ['POST'])]
    public function resetPWD(Request $request, UserPasswordHasherInterface $hasher): JsonResponse
    {
        $params  = $request->toArray();
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['phone' => $params['phone']]);
        $pwd = $params['pwd1'];
        $em = $this->doctrine->getManager();
        $user->setPlainPassword($pwd);
        $em->flush();
        $code = 0;

        return $this->json([
            'code' => $code,
        ]);
    }

    #[Route('/sms', methods: ['POST'])]
    public function sms(Sms $sms, Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $phone = $params['phone'];
        $sms->send($phone);
        return $this->json([
            'code' => 0,
        ]);
    }

    #[Route('/chkotp', methods: ['POST'])]
    public function chkotp(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $phone = $params['phone'];
        $otp = $params['otp'];
        $cache = new RedisAdapter(RedisAdapter::createConnection('redis://localhost'));
        $otp0 = $cache->get($phone, function (ItemInterface $item){
            return 0;
        });
        dump($otp0);

        if ($otp == $otp0) {
            $code = 0;
        } else {
            $code = 1;
        }
        return $this->json([
            'code' => $code,
        ]);
    }

    #[Route('/refretail/{cid}', requirements: ['cid' => '\d+'],  methods: ['GET'])]
    public function refRetail(int $cid): JsonResponse
    {
        $myRefs = $this->doctrine->getRepository(Consumer::class)->findBy(['referrer' => $cid]);
        // dump($myRefs);
        // $refRetails = $this->doctrine->getRepository(Retail::class)->findByMyRefs($myRefs);
        $refRetails = [];
        foreach ($myRefs as $v) {
            // dump($v);
            $retails = $this->doctrine->getRepository(Retail::class)->findBy(['consumer' => $v]);
            // dump($retails);
            $refRetails = array_merge($refRetails, $retails);
        }
        // dump($refRetails);
        return $this->json($refRetails);
    }

    #[Route('/chkphone', methods: ['POST'])]
    public function chkPhone(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $phone = $params['phone'];
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['phone' => $phone]);
        if ($user) {
            $code = 0;
        } else {
            $code = 1;
        }
        return $this->json([
            'code' => $code,
        ]);
    }

    #[Route('/orgs-have-stock-of-product/{pid}', methods: ['GET'])]
    public function orgsHaveStock(int $pid): JsonResponse
    {
        $product = $this->doctrine->getRepository(Product::class)->find($pid);
        $stocks = $this->doctrine->getRepository(Stock::class)->findBy(['product' => $product]);
        $orgs = [];
        foreach ($stocks as $stock) {
            $orgType = $stock->getOrg()->getType();
            if ($orgType != 0 && $orgType != 1 && $orgType != 5) {
                array_push($orgs, $stock->getOrg());
            }
        }
        return $this->json($orgs);
    }

    #[Route('/create-user-org', methods: ['POST'])]
    public function createUserAndOrg(Request $request): JsonResponse
    {
        $params  = $request->toArray();
        $org = new Org();
        $org->setAddress($params['address']);
        $org->setContact($params['contact']);
        $org->setDistrict($params['district']);
        $org->setName($params['name']);
        $org->setPhone($params['phone']);
        $org->type($params['type']);
        dump($org);
        $em->persist($org);
        dump($org);

        $user = new User();
        $user->setUsername($params['username']);
        $user->setPlainPassword($params['plainPassword']);
        $user->setOrg($org);

        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();
        dump($org);

        return $this->json(['code' => 0]);
    }
}
