<?php

namespace Piquage\BillerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillerBundle\Entity\Biller;
use Piquage\BillerBundle\Entity\BillTemplate;
use Piquage\BillerBundle\Entity\Bill;


class DefaultController extends Controller {

    /**
     * @Route("/bills")
     * @Template()
     */
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository("PiquageBillerBundle:Bill");

        $bills = $repository->findAll();
        $records = array();
        foreach ($bills as $bill) {
            $billTemplate = $bill->getBillTemplate();
            $biller = $billTemplate->getBiller();
            $record = array(
                'bill' => $bill,
                'billTemplate' => $billTemplate,
                'biller' => $biller,
            );
            $records[] = $record;
        }

        return $this->render('PiquageBillerBundle:Default:index.html.twig', array('records' => $records));
    }

    
    /**
     * @Route("/templates/list/{biller}")
     * @param type $biller
     * @return type 
     * 
     */
    public function listBillTemplatesAction($biller) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillerBundle:Biller");
        $billTemplates = $repository->findOneByName($biller)->getBillTemplates();

        return $this->render('PiquageBillerBundle:Default:index.html.twig', array('templates' => $billTemplates));
    }

}
