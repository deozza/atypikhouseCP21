<?php
namespace App\Controller;

use App\Entity\PasswordReset;
use App\Entity\PasswordResetRequest;
use App\Event\PasswordEvent;
use App\Entity\User;
use App\Form\password\PasswordResetRequestType;
use App\Form\password\PasswordResetType;
use Firebase\JWT\JWT;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Deozza\ResponseMakerBundle\Service\ResponseMaker;


/**
 * @Route("api/")
 */
class PasswordController extends AbstractController
{
    const PASSWORD_RESET_TOKEN_KIND = "passwordResetRequest";

    public function __construct(ResponseMaker $responseMaker,EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->em = $em;
    }

    /**
     *@Route("password/reset/request", name = "post_pasword_reset_request", methods = {"POST"})
     */
    public function postPasswordResetRequestAction(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $passwordResetRequest = new PasswordResetRequest();
        $form = $this->createForm(PasswordResetRequestType::class, $passwordResetRequest);
        $postedRequest = json_decode($request->getContent(), true);
        $form->submit($postedRequest);

        if(!$form->isValid())
        {
            return $this->response->badForm($form);
        }

        $user = $this->em->getRepository(User::class)->findOneByEmail($passwordResetRequest->getEmail());

        if(empty($user) || $user->isActive() === false)
        {
            return $this->response->created([]);
        }

        $token = [
            "uuid" => $user->getUuidAsString(),
            "exp" => date_create('+5 minutes')->format('U'),
            "kind" => self::PASSWORD_RESET_TOKEN_KIND
        ];
        $env = new Dotenv();
        $env->load($this->getParameter('kernel.project_dir').'/.env');
        $secret = getenv('APP_SECRET');

        $JWTtoken = JWT::encode($token, $secret);
        $event = new PasswordEvent(['token'=>$JWTtoken, 'user'=>$user]);
        $eventDispatcher->dispatch(PasswordEvent::PASSWORD_RESET_REQUEST_NAME, $event);

        return $this->response->created([]);
    }

    /**
     *@Route("password/reset", name = "patch_pasword_reset", methods = {"PATCH"})
     */
    public function patchPasswordResetAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $passwordReset = new PasswordReset();
        $form = $this->createForm(PasswordResetType::class, $passwordReset);
        $postedPassword = json_decode($request->getContent(), true);
        $form->submit($postedPassword);

        if(!$form->isValid())
        {
            return $this->response->badForm($form);
        }
        $env = new Dotenv();
        $env->load($this->getParameter('kernel.project_dir').'/.env');
        $secret = getenv('APP_SECRET');

        try
        {
            $token = JWT::decode($passwordReset->getToken(), $secret, ['HS256']);
            if($token->kind !== self::PASSWORD_RESET_TOKEN_KIND)
            {
                return $this->response->badRequest([
                    "children" => [
                        "token" => [
                            "errors" => "The token is invalid"
                        ],
                        "password" => []
                    ]
                ]);
            }
            
            $user = $this->em->getRepository(User::class)->findOneByUuid($token->uuid);
            if(empty($user))
            {
                return $this->response->badRequest([
                    "children" => [
                        "token" => [
                            "errors" => "The token is invalid"
                        ],
                        "password" => []
                    ]
                ]);
            }

            if($user->getLastPasswordUpdate()->getTimestamp() > $token->exp)
            {
                return $this->response->badRequest([
                    "children" => [
                        "token" => [
                            "errors" => "The token is invalid"
                        ],
                        "password" => []
                    ]
                ]);
            }
        }
        catch(\Exception $e)
        {
            return $this->response->badRequest([
                "children" => [
                    "token" => [
                        "errors" => "The token is invalid"
                    ],
                    "password" => []
                ]
            ]);
        }

        $encodedPassword = $encoder->encodePassword($user, $passwordReset->getPassword());
        $user->setPassword($encodedPassword);
        $user->setLastPasswordUpdate(new \DateTime('now'));
        $this->em->flush();
        return $this->response->created($user, ['user_basic']);
    }
}