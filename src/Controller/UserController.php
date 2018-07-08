<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper\Translater;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * Admin Panel : Show list of users
     *
     * @Route("/admin/user/list", name="admin_user_list")
     */
    public function admin_user_list(Request $request)
    {
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show('Admin Panel'), $this->get("router")->generate("admin"));
        $breadcrumbs->addItem(Translater::show('List of users'), $this->get("router")->generate("admin_user_list"));

        $userRep = $this->getDoctrine()->getRepository(User::class);
        $users = $userRep->adminUserList($request);
        
        return $this->render('admin/user/list.html.twig', [
            'page_title' => Translater::show('List of users'),
            'active_menu' => 'admin_users',
            'users' => $users
        ]);
    }
}
