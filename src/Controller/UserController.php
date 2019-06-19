<?php
namespace App\Controller;

use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Deozza\PhilarmonyBundle\Service\FormManager\FormErrorSerializer;
use Deozza\PhilarmonyBundle\Service\ResponseMaker;


/**
 * @Route("api/")
 */
class UserController extends AbstractController
{
    const INVALID_CREDENTIALS = 'Your crendentials are invalids';

    public function __construct(ResponseMaker $responseMaker, FormErrorSerializer $serializer, EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->serializer = $serializer;
        $this->em = $em;
    }
    
}
