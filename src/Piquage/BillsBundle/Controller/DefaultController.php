<?php

namespace Piquage\BillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillsBundle\Entity\Biller;
use Piquage\BillsBundle\Entity\BillTemplate;
use Piquage\BillsBundle\Entity\Bill;


class DefaultController extends Controller {

    /**
     * @Route("/bills")
     * @Template()
     */
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Bill");

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

        return $this->render('PiquageBillsBundle:Default:index.html.twig', array('records' => $records));
    }

    
    /**
     * @Route("/templates/list/{biller}")
     * @param type $biller
     * @return type 
     * 
     */
    public function listBillTemplatesAction($biller) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Biller");
        $billTemplates = $repository->findOneByName($biller)->getBillTemplates();

        return $this->render('PiquageBillsBundle:Default:index.html.twig', array('templates' => $billTemplates));
    }

}
