<?php
namespace App\Controller;

use App\Entity\SubscribeUser;
use App\Entity\User;
use App\Form\user\PatchCurrentUserType;
use App\Form\user\PatchUserType;
use App\Form\user\PostUserType;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Deozza\ResponseMakerBundle\Service\ResponseMaker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("api/")
 */
class UserController extends AbstractController
{
    const FORBIDDEN_MESSAGE = "You are not allowed to access this resource";
    const NOT_FOUND_MESSAGE = "This resource does not exist";
    const USER_ALREADY_EXISTS = "This user already exixts. Chose another username or another email";
    const INVALID_PASSWORD = "Your password is invalid";

    public function __construct(ResponseMaker $responseMaker, EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->em = $em;
    }

    /**
     *@Route("users",
     * name = "get_user_list",
     * methods = {"GET"})
     */
    public function getUserListAction(Request $request)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);

        $users = $this->em->getRepository(User::class)->findAll();

        $count = $request->request->getInt('count', 10);
        $page = $request->request->getInt('page', 1);
        $total = count($users);

        return $this->response->okPaginated($users, ['user_complete'], $count, $page, $total);
    }

    /**
     *@Route("user/{uuid}",
     * requirements={
     *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
     *     },
     * name = "get_user_specific",
     * methods = {"GET"})
     */
    public function getUserSpecificAction(string $uuid)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);

        $user = $this->em->getRepository(User::class)->findOneByUuid($uuid);
        if(empty($user))
        {
            return $this->response->notFound(self::NOT_FOUND_MESSAGE);
        }

        return $this->response->ok($user, ['user_complete']);
    }

    /**
     *@Route("user/current",
     * name = "get_user_current",
     * methods = {"GET"})
     */
    public function getUserCurrentAction()
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        return $this->response->ok($this->getUser(), ['user_basic']);
    }

    /**
     *@Route("user",
     * name = "post_user",
     * methods = {"POST"})
     */
    public function postUserAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $subscribe = new SubscribeUser();
        $postedSubscribe = json_decode($request->getContent(), true);
        $form = $this->createForm(PostUserType::class, $subscribe);

        $form->submit($postedSubscribe);

        if(!$form->isvalid())
        {
            return $this->response->badForm($form);
        }

        $userAlreadyExists = null;

        $usernameAlreadyExists = $this->em->getRepository(User::class)->findByUsername($subscribe->getUsername());
        $emailAlreadyExists = $this->em->getRepository(User::class)->findByEmail($subscribe->getEmail());

        if(!empty($usernameAlreadyExists) || !empty($emailAlreadyExists))
        {
            return $this->response->badRequest(self::USER_ALREADY_EXISTS);
        }

        $user = new User();
        $user->setUsername($subscribe->getUsername());
        $user->setEmail($subscribe->getEmail());

        $password = $encoder->encodePassword($user, $subscribe->getPassword());
        $user->setPassword($password);
        $user->setRegisterDate(new \DateTime('now'));

        $this->em->persist($user);
        $this->em->flush();

        return $this->response->created($user, ['user_basic']);

    }
    
    /**
     *@Route("user/current",
     * name = "patch_user_current",
     * methods = {"PATCH"})
     */
    public function patchUserCurrentAction(Request $request,  UserPasswordEncoderInterface $encoder)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();

        $user = $this->getUser();
        $patchedUser = json_decode($request->getContent(), true);
        $form = $this->createForm(PatchCurrentUserType::class, $user);
        $form->submit($patchedUser , false);

        if(!$form->isValid())
        {
            return $this->response->badForm($form);
        }

        $passwordIsValid = $encoder->isPasswordValid($user, $user->getPlainPassword());
        if(!$passwordIsValid)
        {
            return $this->response->badRequest(self::INVALID_PASSWORD);
        }

        $usernameAlreadyExists = $this->em->getRepository(User::class)->findByUsername($user->getUsername());
        $emailAlreadyExists = $this->em->getRepository(User::class)->findByEmail($user->getEmail());

        if(count($usernameAlreadyExists) > 1 || count($emailAlreadyExists) > 1)
        {
            return $this->response->badRequest(self::USER_ALREADY_EXISTS);
        }

        if($user->getNewPassword() && $user->getNewPassword() != $user->getPlainPassword())
        {
            $user->setPassword($encoder->encodePassword($user, $user->getNewPassword()));
        }
        $this->em->flush();
        return $this->response->ok($user, ['user_basic']);
    }

    /**
     *@Route("user/{uuid}",
     *  requirements={
     *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
     *     },
     * name = "patch_user_specific",
     * methods = {"PATCH"})
     */
    public function patchUserSpecific(string $uuid, Request $request, UserPasswordEncoderInterface $encoder)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);

        $user = $this->em->getRepository(User::class)->findOneByUuid($uuid);
        if(empty($user))
        {
            return $this->response->notFound(self::NOT_FOUND_MESSAGE);
        }

        $patchedUser  = json_decode($request->getContent(), true);
        $form = $this->createForm(PatchUserType::class, $user);
        $form->submit($patchedUser , false);

        if(!$form->isValid())
        {
            return $this->response->badForm($form);
        }

        $usernameAlreadyExists = $this->em->getRepository(User::class)->findByUsername($user->getUsername());
        $emailAlreadyExists = $this->em->getRepository(User::class)->findByEmail($user->getEmail());

        if(count($usernameAlreadyExists) > 1 || count($emailAlreadyExists) > 1)
        {
            return $this->response->badRequest(self::USER_ALREADY_EXISTS);
        }

        if($user->getNewPassword() && $user->getNewPassword() != $user->getPlainPassword())
        {
            $user->setPassword($encoder->encodePassword($user, $user->getNewPassword()));
        }

        $this->em->flush();
        return $this->response->ok($user, ['user_complete']);
    }
}
