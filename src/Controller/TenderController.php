<?php

namespace App\Controller;

use App\Entity\Tender;
use App\Form\TenderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tender")
 */
class TenderController extends Controller
{
    /**
     * @Route("/", name="tender_index", methods="GET")
     */
    public function index(): Response
    {
        $tenders = $this->getDoctrine()
            ->getRepository(Tender::class)
            ->findAll();

        return $this->render('tender/index.html.twig', ['tenders' => $tenders]);
    }

    /**
     * @Route("/new", name="tender_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $tender = new Tender();
        $form = $this->createForm(TenderType::class, $tender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tender);
            $em->flush();

            return $this->redirectToRoute('tender_index');
        }

        return $this->render('tender/new.html.twig', [
            'tender' => $tender,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tender_show", methods="GET")
     */
    public function show(Tender $tender): Response
    {
        return $this->render('tender/show.html.twig', ['tender' => $tender]);
    }

    /**
     * @Route("/{id}/edit", name="tender_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tender $tender): Response
    {
        $form = $this->createForm(TenderType::class, $tender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tender_edit', ['id' => $tender->getId()]);
        }

        return $this->render('tender/edit.html.twig', [
            'tender' => $tender,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tender_delete", methods="DELETE")
     */
    public function delete(Request $request, Tender $tender): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tender->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tender);
            $em->flush();
        }

        return $this->redirectToRoute('tender_index');
    }
}
