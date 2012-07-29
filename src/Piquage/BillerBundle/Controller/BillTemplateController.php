<?php

namespace Piquage\BillerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillerBundle\Entity\BillTemplate;
use Piquage\BillerBundle\Entity\Biller;
use Piquage\BillerBundle\Entity\Bill;

class BillTemplateController extends Controller {

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response 
     * @Route("/bill/template/create")
     */
    public function createAction() {
        $repository = $this->getDoctrine()->getRepository('PiquageBillerBundle:Biller');
        $biller = $repository->findOneByName('usaa');


        $billTemplate = new BillTemplate();
        $billTemplate->setBiller($biller);
        $billTemplate->setAutoDebit(false);
        $billTemplate->setAvgAmount(80);
        $billTemplate->setNickname("vespa");
        $billTemplate->setRecurrenceType("monthly");
        $billTemplate->setRecurrenceDay(1);
        $billTemplate->setActive(true);

        $em = $this->getDoctrine()->getEntityManager();
//        $em->persist($biller);
        $em->persist($billTemplate);
        $em->flush();

        return new Response('Created bill template with id: ' . $billTemplate->getId() . ' and biller with id: ' . $biller->getId());
    }

}