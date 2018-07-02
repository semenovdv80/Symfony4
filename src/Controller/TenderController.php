<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Tender;
use Doctrine\Common\EventManager;
use Gedmo\Tree\TreeListener;
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
        $tenderRep = $this->getDoctrine()->getRepository(Tender::class);
        $aData['todaylots'] = number_format($tenderRep->getTodayTendersCount());
        $aData['sumtoday'] = number_format($tenderRep->getTodayTendersSum()/1000000);
        $aData['toptenders'] = $tenderRep->getTopTenders();
        $aData['categories'] = [];

        return $this->render('tender/index.html.twig', $aData);
    }

    /**
     * @Route("/add", name="tender_add", methods="GET")
     */
    public function add()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $food = new Category();
        $food->setTitle('Food');

        $fruits = new Category();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $em->persist($food);
        $em->persist($fruits);

        $em->flush();

        return true;
    }
}
