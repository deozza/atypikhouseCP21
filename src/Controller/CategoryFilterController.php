<?php

namespace App\Controller;

use App\Entity\CategoryFilter;
use App\Form\auth\PostCategoryFilterType;
use Deozza\ResponseMakerBundle\Service\ResponseMaker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/")
 */
class CategoryFilterController extends AbstractController
{
    const FORBIDDEN_MESSAGE = "You are not allowed to access this resource";
    const NOT_FOUND_MESSAGE = "This resource does not exist";

    public function __construct(ResponseMaker $responseMaker, EntityManagerInterface $em)
    {
        $this->response = $responseMaker;
        $this->em = $em;
    }

    /**
     *@Route("categoryFilters",
     * name = "get_category_filter_list",
     * methods = {"GET"})
     */
    public function getFilterListAction(Request $request)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);
        $filters = $this->em->getRepository(CategoryFilter::class)->findAll();
        return $this->response->ok($filters, ['categoryFilter_basic']);
    }

    /**
     *@Route("categoryFilter/{uuid}",
     * name = "get_category_filter",
     * requirements={
     *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
     *     },
     * methods = {"GET"})
     */
    public function getFilterAction(Request $request, string $uuid)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);
        $filter = $this->em->getRepository(CategoryFilter::class)->findOneByUuid($uuid);

        if(empty($filter))
        {
            return $this->response->notFound(self::NOT_FOUND_MESSAGE);
        }
        return $this->response->ok($filter, ['categoryFilter_basic']);
    }

    /**
     *@Route("categoryFilter",
     * name = "pos_category_filter",
     * methods = {"POST"})
     */
    public function postFilterAction(Request $request)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);

        $filter = new CategoryFilter();
        $postedFilter = json_decode($request->getContent(), true);
        $form = $this->createForm(PostCategoryFilterType::class, $postedFilter);




        return $this->response->ok($filter, ['categoryFilter_basic']);
    }

    /**
     *@Route("categoryFilter/{uuid}",
     * name = "delete_category_filter",
     * requirements={
     *          "uuid" = "[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}",
     *     },
     * methods = {"DELETE"})
     */
    public function deleteFilterAction(Request $request, string $uuid)
    {
        if(empty($this->getUser()->getId())) return $this->response->notAuthorized();
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) return $this->response->forbiddenAccess(self::FORBIDDEN_MESSAGE);
        $filter = $this->em->getRepository(CategoryFilter::class)->findOneByUuid($uuid);

        if(empty($filter))
        {
            return $this->response->notFound(self::NOT_FOUND_MESSAGE);
        }

        $this->em->remove($filter);
        $this->em->flush();
        return $this->response->empty();
    }

}