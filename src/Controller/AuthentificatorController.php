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
use Deozza\PhilarmonyBundle\Service\FormManager\FormErrorSerializer;
use Deozza\PhilarmonyBundle\Service\ResponseMaker;


/**
* @Route("api/token")
*/

class AuthentificatorController extends AbstractController
{
  const INVALID_CREDENTIALS = 'Your crendentials are invalids';
  private $em;
  private $response;
  private $serializer;

  public function __contruct(ResponseMaker $responseMaker, FormErrorSerializer $serializer, EntityManagerInterface $em)
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
    $env->load($this->getParameters('kernel.project_dir').'/.env');
    $secret = getenv('APP_SECRET');
    $token = ['username' => $user->getUsername(), 'exp' => date_create('+1 day')->format('U')];
    $authToken = new ApiToken($user, JWT::encode($token, $secret));
    $this->em->persist($authToken);
    $user->setLastLogin(new \DateTime('now'));
    $this->em->persist($user);
    $this->em->flush();
    return $this->response->created($authToken);

  }
}
