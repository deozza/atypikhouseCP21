<?php
namespace App\Controller;

use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Deozza\ResponseMakerBundle\Service\ResponseMaker;
use Deozza\ResponseMakerBundle\Service\FormErrorSerializer;


/**
 * @Route("api/")
 */
class UserController extends AbstractController
{

    const FORBIDDEN_MESSAGE = "You are not allowed to access this resource";

    public function __construct(ResponseMaker $responseMaker, FormErrorSerializer $serializer, EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     *@Route("users",
     * name = "get_user_list",
     * methods = {"GET"})
     */
    public function getUserListAction()
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);
        return $this->response->ok([]);
    }

    /**
     *@Route("user/{uuid}",
     * requirements={
     *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
     *     },
     * name = "get_user_specific",
     * methods = {"GET"})
     */
    public function getUserSpecificAction($uuid)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);
        return $this->response->ok([]);
    }

    /**
     *@Route("user/current",
     * name = "get_user_current",
     * methods = {"GET"})
     */
    public function getUserCurrentAction()
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        return $this->response->ok([]);
    }

    /**
     *@Route("user",
     * name = "post_user",
     * methods = {"POST"})
     */
    public function postUserAction(Request $request)
    {
        return $this->response->created([]);

    }


    /**
     *@Route("user/current",
     * name = "patch_user_current",
     * methods = {"PATCH"})
     */
    public function patchUserCurrentAction(Request $request)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        return $this->response->ok([]);
    }


    /**
     *@Route("user/{uuid}",
     *  requirements={
     *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
     *     },
     * name = "patch_user_specific",
     * methods = {"PATCH"})
     */
    public function patchUserSpecific(Request $request, $uuid)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);
        return $this->response->ok([]);
    }



}
