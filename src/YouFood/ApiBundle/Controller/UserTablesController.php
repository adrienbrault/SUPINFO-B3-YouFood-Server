<?php

namespace YouFood\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\RouteRedirectView;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use YouFood\UserBundle\Repository\UserRepository;
use YouFood\MainBundle\Repository\TableRepository;

/**
 * UserTablesController
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 *
 * @NamePrefix("youfood_api_rest_")
 */
class UserTablesController extends Controller
{
    /**
     * @param int $user_id The user id
     *
     * @return View
     *
     * @ApiDoc(resource=true, description="Get all tables an user has been assigned.")
     * @Route(requirements={"user_id"="\d+"})
     */
    public function getTablesAction($user_id)
    {
        $user = $this->getUserRepository()->find($user_id);

        if (null === $user) {
            throw $this->createNotFoundException('User not found.');
        }

        $tables = $this->getTableRepository()->getTablesAssignedTo($user);

        $view = View::create($tables);
        $view->setSerializerGroups(array('id'));

        return $view;
    }

    /**
     * @return UserRepository
     */
    protected function getUserRepository()
    {
        return $this->getDoctrine()->getRepository('YouFoodUserBundle:User');
    }

    /**
     * @return TableRepository
     */
    protected function getTableRepository()
    {
        return $this->getDoctrine()->getRepository(sprintf('YouFoodMainBundle:Table'));
    }
}
