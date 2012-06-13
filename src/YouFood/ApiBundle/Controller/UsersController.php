<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\UserBundle\Repository\UserRepository;

/**
 * UsersController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class UsersController extends Controller
{
    /**
     * @param string $id The user id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get an user")
     * @Route(requirements={"id"="\d+"})
     */
    public function getUserAction($id)
    {
        $user = $this->getRepository()->find($id);

        if (null === $user) {
            throw $this->createNotFoundException('User not found.');
        }

        $view = View::create($user);
        $view->setSerializerGroups(array('id'));

        return $view;
    }

    /**
     * @return UserRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodUserBundle:User');
    }
}
