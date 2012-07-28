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
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name) {
        return array('name' => $name);
    }

    /**
     * @Route("/biller/create") 
     */
    public function createAction() {

        $biller = new Biller();
        $biller->setName('entergy');
        $biller->setWebsite('entergy.com');
        
        $biller->setCreated(new \DateTime());
        $biller->setUpdated(new \DateTime());

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($biller);
        $em->flush();
        
        return $this->render('PiquageBillerBundle:Default:billers.html.twig', array('biller' => $biller));

    }
    
    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response 
     * @Route("/biller/template/create")
     */
    public function createBillTemplateAction(){
        $repository = $this->getDoctrine()->getRepository('PiquageBillerBundle:Biller');
        $biller = $repository->findOneByName('usaa');
        
        
        $billTemplate = new BillTemplate();
        $billTemplate->setBiller($biller);
        $billTemplate->setAutoDebit(false);
        $billTemplate->setAvgAmount(100);
        $billTemplate->setNickname("insurance");
        $billTemplate->setRecurrenceType("monthly");
        $billTemplate->setRecurrenceDay(24);
        $billTemplate->setCreated(new \DateTime());
        $billTemplate->setUpdated(new \DateTime());
        $billTemplate->setActive(true);

        $em = $this->getDoctrine()->getEntityManager();
//        $em->persist($biller);
        $em->persist($billTemplate);
        $em->flush();

        return new Response('Created bill template with id: '.$billTemplate->getId().' and biller with id: '.$biller->getId());
    }


    
    
}
