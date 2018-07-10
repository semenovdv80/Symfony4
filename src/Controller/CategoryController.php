<?php

namespace App\Controller;

use App\Entity\Category;
use App\Helper\Translater;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * Admin Panel : Show list of categories
     *
     * @Route("/admin/category/list", name="admin_category_list")
     */
    public function admin_category_list(Request $request)
    {
        Translater::setLocale($request->getLocale());
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem(Translater::show('Admin Panel'), $this->get("router")->generate("admin"));
        $breadcrumbs->addItem(Translater::show('List of categories'), $this->get("router")->generate("admin_category_list"));

        return $this->render('admin/category/index.html.twig', [
            'page_title' => Translater::show('List of categories'),
            'active_menu' => 'admin_categories'
        ]);
    }

    /**
     * Admin Panel : Show categories tree
     *
     * @Route("/admin/category/gettree", name="admin_category_gettree")
     * @return JsonResponse
     */
    public function gettree()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App\Entity\Category');

        //recovery tree
        $repo->recover();
        $em->flush();

        $repo->setChildrenIndex('children'); #for jstree: in response set this dir for children
        $tree = $repo->childrenHierarchy(null, false); #null - from root node; false - all descendants, true - only first childeren

        return new JsonResponse($tree);
    }

    /**
     * Admin Panel : Move node by tree
     *
     * @Route("/admin/category/settree", name="admin_category_settree")
     * @param Request $request
     * @return JsonResponse
     */
    public function settree(Request $request)
    {
        #if (not permits) return new JsonResponse(false);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App\Entity\Category');

        $category_id = $request->get('node_id');
        $parent_id = $request->get('parent_id');

        $category = $repo->find($category_id);
        $parent = $repo->find($parent_id);
        $category->setParent($parent);

        $repo->recover();
        $em->flush();

        return $repo->verify() === true ? new JsonResponse(true) : new JsonResponse('error');
    }

    /**
     *  Admin Panel : Create new category
     *
     * @Route("/admin/category/add", name="admin_category_add")
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App\Entity\Category');

        //get params from request
        $text = $request->get('text');
        $parent_id = $request->get('parent_id');

        //get parent category
        $parent = $repo->find($parent_id);

        //create new category
        $category = new Category();
        $category->setText($text);
        $category->setParent($parent);

        //save category
        $em->persist($category);
        $em->flush();

        return new JsonResponse($category->getId());
    }

    /**
     *  Admin Panel : Edit category
     *
     * @Route("/admin/category/edit", name="admin_category_edit")
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App\Entity\Category');

        //get params from request
        $text = $request->get('text');
        $category_id = $request->get('id');

        //get parent category
        $category = $repo->find($category_id);

        //edit category
        $category->setText($text);

        //save category
        $em->persist($category);
        $em->flush();

        return new JsonResponse($category->getId());
    }

    /**
     *  Admin Panel : Delete category
     *
     * @Route("/admin/category/delete", name="admin_category_delete")
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        //get params from request
        $token = $request->get('token');
        $item_id = $request->get('item_id');
        $redirect_to = $request->get('redirect_to');

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App\Entity\Category');

        //get category
        $category = $repo->find($item_id);

        //check if exists and token
        if ($category && $this->isCsrfTokenValid('delete-item', $token)) {
            //delete category
            $em->remove($category);
            $em->flush();
            $this->get('session')->set('action_result', 'success');
            return  new JsonResponse(true);
        }
        return  new JsonResponse(false);
    }
}
