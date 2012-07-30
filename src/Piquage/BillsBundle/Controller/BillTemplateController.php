<?php

namespace Piquage\BillsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Piquage\BillsBundle\Form\Type\BillTemplateType;
use Piquage\BillsBundle\Entity\BillTemplate;
use Piquage\BillsBundle\Entity\Biller;
use Piquage\BillsBundle\Entity\Bill;

class BillTemplateController extends Controller {
//    /**
//     *
//     * @return \Symfony\Component\HttpFoundation\Response 
//     * @Route("/bill/template/create")
//     */
//    public function createAction() {
//        $repository = $this->getDoctrine()->getRepository('PiquageBillsBundle:Biller');
//        $biller = $repository->findOneByName('usaa');
//
//
//        $billTemplate = new BillTemplate();
//        $billTemplate->setBiller($biller);
//        $billTemplate->setAutoDebit(false);
//        $billTemplate->setAvgAmount(80);
//        $billTemplate->setNickname("vespa");
//        $billTemplate->setRecurrenceType("monthly");
//        $billTemplate->setRecurrenceDay(1);
//        $billTemplate->setActive(true);
//
//        $em = $this->getDoctrine()->getEntityManager();
////        $em->persist($biller);
//        $em->persist($billTemplate);
//        $em->flush();
//
//        return new Response('Created bill template with id: ' . $billTemplate->getId() . ' and biller with id: ' . $biller->getId());
//    }

    /**
     * @Route("/templates", name="list_templates")
     * @return Response 
     */
    public function listAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT b FROM PiquageBillsBundle:BillTemplate b ORDER BY b.nickname ASC');

        $records = $query->getResult();
        return $this->render('PiquageBillsBundle:BillTemplate:index.html.twig', array('records' => $records));
    }

    /**
     * @Route("/templates/{nickname}/info", name="show_template")
     * @param type $nickname
     * @return Response 
     */
    public function showAction($nickname) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:BillTemplate");
        $record = $repository->findOneByNickname($nickname);
        return $this->render('PiquageBillsBundle:BillTemplate:info.html.twig', array('record' => $record));
    }

    /**
     * @Route("/templates/new", name="new_template")
     * @Route("/templates/{nickname}/edit", name="edit_template")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request, $nickname = null) {
        if ($nickname) {
            $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:BillTemplate");
            $record = $repository->findOneByNickname($nickname);
            $button = 'Update';
        } else {
            $record = new BillTemplate();
            $button = 'Add';
        }

        $form = $this->createForm(new BillTemplateType(), $record);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($record);
                $em->flush();

                return $this->redirect($this->generateUrl('list_templates'));
            }
        }

        return $this->render('PiquageBillsBundle:BillTemplate:new.html.twig', array(
                    'form' => $form->createView(),
                    'button' => $button,
                ));
    }

    /**
     * @Route("/templates/{nickname}/delete", name="delete_template")
     * @return Response 
     */
    public function removeAction($nickname) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:BillTemplate");
        $record = $repository->findOneByName($nickname);

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($record);
        $em->flush();

        return $this->redirect($this->generateUrl('list_templates'));
    }

}