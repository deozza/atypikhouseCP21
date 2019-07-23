<?php
namespace App\Controller;

use App\Form\auth\AuthentificatorType;
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


/**
 * @Route("api/")
 */
class PasswordController extends AbstractController
{
    public function __construct(ResponseMaker $responseMaker,EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->em = $em;
    }

    /**
     *@Route("password/reset/request", name = "post_pasword_reset_request", methods = {"POST"})
     */
    public function postPasswordResetRequestAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

    }

    /**
     *@Route("password/reset", name = "patch_pasword_reset", methods = {"PATCH"})
     */
    public function patchPasswordResetAction(Request $request, UserPasswordEncoderInterface $encoder)
    {

    }
}