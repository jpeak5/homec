<?php

namespace Piquage\BillsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Piquage\BillsBundle\Entity\BillTemplate;
use Piquage\BillsBundle\Entity\Biller;
use Piquage\BillsBundle\Entity\Bill;
use Symfony\Component\HttpFoundation\Request;
use Piquage\BillsBundle\Form\Type\BillerType;

class BillerController extends Controller {

    /**
     * @Route("/billers", name="list_billers")
     * @return Response 
     */
    public function listAction() {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Biller");
        $records = $repository->findAll();
        return $this->render('PiquageBillsBundle:Biller:index.html.twig', array('records' => $records));
    }

    /**
     * @Route("/billers/{name}/info", name="show_biller")
     * @param type $name
     * @return Response 
     */
    public function showAction($name) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Biller");
        $record = $repository->findOneByName($name);
        return $this->render('PiquageBillsBundle:Biller:show.html.twig', array('record' => $record));
    }

    /**
     * @Route("/billers/new", name="new_biller")
     * @Route("/billers/{name}/edit", name="edit_biller")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request, $name = null) {
        if ($name) {
            $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Biller");
            $record = $repository->findOneByName($name);
            $button = 'Update';
        } else {
            $record = new Biller();
            $button = 'Add';
        }

        $form = $this->createForm(new BillerType(), $record);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($record);
                $em->flush();

                return $this->redirect($this->generateUrl('list_billers'));
            }
        }

        return $this->render('PiquageBillsBundle:Biller:new.html.twig', array(
                    'form' => $form->createView(),
                    'button' => $button,
                ));
    }

    /**
     * @Route("/billers/{name}/delete", name="delete_biller")
     * @return Response 
     */
    public function removeAction($name) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Biller");
        $record = $repository->findOneByName($name);

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($record);
        $em->flush();

        return $this->redirect($this->generateUrl('list_billers'));
    }

}

?>
