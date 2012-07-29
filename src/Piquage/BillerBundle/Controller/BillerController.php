<?php

namespace Piquage\BillerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillerBundle\Entity\BillTemplate;
use Piquage\BillerBundle\Entity\Biller;
use Piquage\BillerBundle\Entity\Bill;
use Symfony\Component\HttpFoundation\Request;
use Piquage\BillerBundle\Form\Type\BillerType;

class BillerController extends Controller {

    /**
     * @Route("/billers", name="billers_list")
     * @return type 
     */
    public function listAction() {
        $repository = $this->getDoctrine()->getRepository("PiquageBillerBundle:Biller");

        $billers = $repository->findAll();

        return $this->render('PiquageBillerBundle:Biller:index.html.twig', array('records' => $billers));
    }

    /**
     * @Route("/billers/{name}/info", name="show_biller")
     * @param type $name
     * @return type 
     */
    public function showAction($name) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillerBundle:Biller");
        $biller = $repository->findOneByName($name);

        return $this->render('PiquageBillerBundle:Biller:show.html.twig', array('record' => $biller));
    }

    /**
     * @Route("/billers/new", name="new_biller")
     * @Route("/billers/{name}/edit", name="edit_biller")
     * @param Request $request
     * @return type 
     */
    public function newAction(Request $request, $name = null) {
        if ($name) {
            $repository = $this->getDoctrine()->getRepository("PiquageBillerBundle:Biller");
            $biller = $repository->findOneByName($name);
            $button = 'Update';
        } else {
            $biller = new Biller();
            $button = 'Add';
        }

        $form = $this->createForm(new BillerType(), $biller);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                
                    $em->persist($biller);
                
                $em->flush();

                return $this->redirect($this->generateUrl('billers_list'));
            }
        }

        return $this->render('PiquageBillerBundle:Biller:new.html.twig', array(
                    'form' => $form->createView(),
                    'button' => $button,
                ));
    }

    public function removeAction() {
        $repository = $this->getDoctrine()->getRepository("PiquageBillerBundle:Biller");
        $biller = $repository->findOneByName($name);

        $form = $this->createForm(new BillerType(), $biller);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($biller);
                $em->flush();

                return $this->redirect($this->generateUrl('billers_list'));
            }
        }

        return $this->render('PiquageBillerBundle:Biller:new.html.twig', array(
                    'form' => $form->createView(),
                    'button' => $button,
                ));
    }

}

?>
