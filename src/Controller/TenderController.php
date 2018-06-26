<?php

namespace App\Controller;

use App\Entity\Tender;
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
        $aData['todaylots'] = number_format($this->getDoctrine()->getRepository(Tender::class)->getTodayTendersCount());
        $aData['sumtoday'] = $this->getDoctrine()->getRepository(Tender::class)->getTodayTendersSum();

        $aData['toplots'] = $this->getDoctrine()->getRepository(Tender::class)->getTopTenders();


        dd(var_dump($aData['toplots']));





        $tenders = $this->getDoctrine()
            ->getRepository(Tender::class)
            ->findAll();

        return $this->render('tender/index.html.twig', ['tenders' => $tenders]);

        $aData['todaylots'] = number_format(Tender::whereDate('close_date', '>=', Carbon::today())
            ->count());
        $aData['sumtoday'] = number_format(Tender::whereDate('close_date', '>=', Carbon::today())
                ->sum('amount') / 1000000);


    }
}
