<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * Show categories tree
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
     * Move node by tree
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
     *  Create new category
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
        $parent_id = $request->get('parent');

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
     *  Edit category
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
}