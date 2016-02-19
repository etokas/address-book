<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 09/02/2016
 * Time: 16:27
 */

namespace bundle\FrontBundle\Controller;


use bundle\FrontBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * @RouteResource("User")
 */
class ApiController extends Controller
{

    // Fonction qui me retourne tout les utilisateur
    /**
     * GET Route annotation.
     * @Get("/users")
     */

    public function getAllUsersAction()
    {
        // Cette methode est crée dans le repository
        $users = $this->getRepository()->getMailAndLogin();

        return new JsonResponse($users);
    }


    //La fonction qui me retourne un utilisateur

    /**
     * GET Route annotation.
     * @Get("/users/{id}")
     *
     * @param $id
     * @return User
     */
    public function getUserAction($id)
    {
        // Cette methode est crée dans le repository
        $user = $this->getRepository()->getUser($id);

        if(!$user){

            return new Response('<html><body><h3>Hééé !!! Cet utilisateur n\'existe pas</h3></body></html>', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user);
    }

    private function getRepository()
    {
        return $em = $this->getDoctrine()->getManager()->getRepository("FrontBundle:User");
    }


}