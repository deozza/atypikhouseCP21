<?php
namespace App\Controller;

use App\Form\AuthentificatorType;
use App\Entity\ApiToken;
use App\Entity\Credentials;
use App\Entity\User;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Deozza\ResponseMakerBundle\Service\ResponseMaker;
use Deozza\ResponseMakerBundle\Service\FormErrorSerializer;


/**
 * @Route("api/token")
 */
class AuthentificatorController extends AbstractController
{
    const INVALID_CREDENTIALS = 'Your crendentials are invalids';
    const NOT_FOUND = 'Resource not found';

    public function __construct(ResponseMaker $responseMaker, FormErrorSerializer $serializer, EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     *@Route("", name = "POST_Authentificator", methods = {"POST"})
     */
    public function authentificatorAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $credentials = new Credentials();
        $postedCredentials = json_decode($request->getContent(), true);
        $form = $this->createForm(AuthentificatorType::class, $credentials);
        $form->submit($postedCredentials);
        if (!$form->isValid())
        {
            return $this->response->badRequest($this->serializer->convertFormToArray($form));
        }
        $repository = $this->em->getRepository(User::class);
        $user = $repository->findByUsernameOrEmail($credentials->getLogin());
        if (empty($user) || $user[0]->getActive() == false)
        {
            return $this->response->badRequest(self::INVALID_CREDENTIALS);
        }
        $user = $user[0];
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());
        if (!$isPasswordValid)
        {
            $user->setLastFailedLogin(new \DateTime('now'));
            $this->em->persist($user);
            $this->em->flush();
            return $this->response->badRequest(self::INVALID_CREDENTIALS);
        }
        $env = new Dotenv();
        $env->load($this->getParameter('kernel.project_dir').'/.env');
        $secret = getenv('APP_SECRET');
        $token = ['username' => $user->getUsername(), 'exp' => date_create('+1 day')->format('U')];
        $authToken = new ApiToken($user, JWT::encode($token, $secret));
        $this->em->persist($authToken);
        $user->setLastLogin(new \DateTime('now'));
        $this->em->persist($user);
        $this->em->flush();
        return $this->response->created($authToken);

    }

      /**
      *@Route("/{uuid}",
      *requirements={
      *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
      *     },
      * name = "DELETE_Token",
      * methods = {"DELETE"})
      */
    public function disconnectAction(Request $request, $uuid)
    {
      if (empty($this->getUser()->getId()))
      {
        return $this->response->notAuthorized();
      }
      $repository = $this->em->getRepository(ApiToken::class);
      $token = $repository->findOneByUuid($uuid);
      if (empty($token))
      {
        return $this->response->notFound(self::NOT_FOUND);
      }
      $tokenSent = $request->headers->get('Authorization');
      $tokenSent = substr($tokenSent, 7);
      if ($tokenSent !== $token->getToken())
      {
        return $this->response->notFound(self::NOT_FOUND);
      }
      $this->em->remove($token);
      $this->em->flush();
      return $this->response->empty();
    }
}
