<?php
namespace App\Controller;

use Deozza\PhilarmonyCoreBundle\Controller\BaseController;
use Deozza\PhilarmonyCoreBundle\Entity\Entity;
use Deozza\PhilarmonyCoreBundle\Service\Authorization\AuthorizeAccessToEntity;
use Deozza\PhilarmonyCoreBundle\Service\Authorization\AuthorizeRequest;
use Deozza\PhilarmonyCoreBundle\Service\DatabaseSchema\DatabaseSchemaLoader;
use Deozza\PhilarmonyCoreBundle\Service\FormManager\FormGenerator;
use Deozza\PhilarmonyCoreBundle\Service\RulesManager\RulesManager;
use Deozza\PhilarmonyCoreBundle\Service\Validation\ManualValidation;
use Deozza\PhilarmonyCoreBundle\Service\Validation\Validate;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Deozza\ResponseMakerBundle\Service\ResponseMaker;

/**
 * @Route("api/")
 */
class PaypalController extends AbstractController
{
    private $token;
    const AUTH_URI = 'v1/oauth2/token';

    public function __construct(
        ResponseMaker $responseMaker,
        EntityManagerInterface $em
    )
    {
        $this->response = $responseMaker;
        $this->em = $em;
        $this->client = new Client([
            'base_uri'=>'https://api.sandbox.paypal.com/',
            'timeout'=>180,
        ]);
    }

    /**
     *@Route("reservation/{entity_id}/paypal", name = "post_payment", methods = {"POST"})
     */
    public function postPaymentForReservation(Request $request, string $entity_id)
    {
        $user = empty($this->getUser()->getUuid()) ? null : $this->getUser();
        if(empty($user))
        {
            return $this->response->notAuthorized();
        }

        $entity = $this->em->getRepository(Entity::class)->findOneByUuid($entity_id);
        if(empty($entity) || $entity->getKind() !== 'reservation')
        {
            return $this->response->notFound('Resource not found');
        }

        if($user->getUuidAsString() !== $entity->getOwner()->getUuid())
        {
            return $this->response->forbiddenAccess('You are not allowed to access to this resource');
        }

        $token = $this->paypalAuth();

        if(empty($token))
        {
            return $this->response->badRequest('Authentication to paypal API has failed');
        }

        $this->token = $token;

    }

    private function paypalAuth()
    {
        $env = new Dotenv();
        $env->load($this->getParameter('kernel.project_dir').'/.env');
        $userid = getenv('PAYPAL_USERID');
        $secret = getenv('PAYPAL_SECRET');
        $response = $this->client->request('POST' ,self::AUTH_URI, [
            'auth'=>[$userid, $secret],
            'form_params'=> ['grant_type'=>'client_credentials']
        ]);

        if($response->getStatusCode() !== 200)
        {
            return null;
        }

        $response = json_decode($response->getBody()->getContents());

        return $response->access_token;
    }
}