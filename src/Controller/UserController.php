<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    /**
     * @Rest\Get("/api/users", methods={"GET"})
     * @Rest\View
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of users",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=App\Entity\User::class)
     *     )
     * )
     * @SWG\Tag(name="User Service")
     */
    public function index()
    {
        return $this->getDoctrine()->getRepository(User::class)->findAll();
    }

}
