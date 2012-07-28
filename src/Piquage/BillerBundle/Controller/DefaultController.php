<?php

namespace Piquage\BillerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillerBundle\Entity\Biller;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     *@Route("/biller/create") 
     */
    public function createAction(){
        
        
        
    $biller = new Biller();
    $biller->setName('usaa');
    $biller->setWebsite('usaa.com');
    $biller->setAutoDebit(false);
    $biller->setCreated(new \DateTime());
    $biller->setUpdated(new \DateTime());

    $em = $this->getDoctrine()->getEntityManager();
    $em->persist($biller);
    $em->flush();

    return new Response('Created biller id '.$biller->getId());
}
    
}
