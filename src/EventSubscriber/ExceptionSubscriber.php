<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        // dd($event);
        // dump($exception);

        // https://symfony.com/doc/current/security.html#customizing-logout
        // $response = new RedirectResponse(
        //     $this->urlGenerator->generate('homepage'),
        //     RedirectResponse::HTTP_SEE_OTHER
        // );
        $response = new Response();

        // Customize your response object to display the exception details
        if ($exception instanceof NotFoundHttpException) {
        }
        if ($exception instanceof AccessDeniedException) {
        }
        if ($exception instanceof DriverException){
            $message = sprintf(
                '库存不足！错误代码: %s',
                // $exception->getMessage(),
                $exception->getCode()
            );
            // sends the modified response object to the event
            $response->setContent($message);
            // $event->setResponse($response);
        }
        if ($exception->getCode() == 44) {
            $message = sprintf(
                '退货方无此商品！错误代码: %s',
                // $exception->getMessage(),
                $exception->getCode()
            );
            // sends the modified response object to the event
            $response->setContent($message);
            $event->setResponse($response);
        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
