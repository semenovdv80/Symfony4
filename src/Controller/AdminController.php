<?php

namespace App\Controller;

use App\Helper\Translater;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * Admin Panel : Main Menu
     *
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show('Admin Panel'), $this->get("router")->generate("admin"));

        return $this->render('admin/index.html.twig', [
            'page_title' => 'Main Menu',
            'active_menu' => ''
        ]);
    }
}
