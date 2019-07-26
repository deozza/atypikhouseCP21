<?php


namespace App\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            //KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $e = $event->getException();
        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        $response = new JsonResponse(
            ["error"=>$e->getMessage()],
            $statusCode
        );

        $response->headers->set('Content-Type', 'application/json');
        $event->setResponse($response);
    }
}