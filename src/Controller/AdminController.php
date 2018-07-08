<?php

namespace App\Controller;

use App\Helper\Translater;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show('Admin Panel'), $this->get("router")->generate("admin"));

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'page_title' => 'Main Menu',
            'active_menu' => '',
            'active_page' => ''
        ]);
    }

    /**
     * @Route("/admin/categories/index", name="admin_categories_index")
     */
    public function admin_categories_index(Request $request)
    {
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show('Admin Panel'), $this->get("router")->generate("admin"));
        $breadcrumbs->addItem(Translater::show('List of categories'), $this->get("router")->generate("admin_categories_index"));

        return $this->render('admin/categories/index.html.twig', [
            'controller_name' => 'AdminController',
            'page_title' => Translater::show('List of categories'),
            'active_menu' => 'admin_categories',
            'active_page' => 'admin_categories_index'
        ]);
    }
}
