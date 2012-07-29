<?php

namespace Piquage\BillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillsBundle\Entity\BillTemplate;
use Piquage\BillsBundle\Entity\Biller;
use Piquage\BillsBundle\Entity\Bill;

class BillsController extends Controller {

    /**
     * @Route("/bill/create")
     * @return type 
     */
    public function createAction() {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:BillTemplate");

        $billTemplate = $repository->findOneByNickname('vespa');

        $bill = new Bill();
        $bill->setAmount(72.34);
        $bill->setBillTemplate($billTemplate);
        $bill->setCleared(null);
        $bill->setConfNumber(null);
        $bill->setDue(new \DateTime('8/01/2012'));
        $bill->setPaid(null);
        $bill->setScheduled(null);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($bill);
//        $em->persist($billTemplate);
        $em->flush();

        return $this->render('PiquageBillsBundle:Default:bills.html.twig', array(
                    'bill' => $bill,
                    'billTemplate' => $billTemplate,
                    'biller' => $billTemplate->getBiller()
                ));
    }

}