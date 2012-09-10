<?php

namespace Piquage\BillsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Piquage\BillsBundle\Form\Type\BillType;
use Piquage\BillsBundle\Entity\BillTemplate;
use Piquage\BillsBundle\Entity\Biller;
use Piquage\BillsBundle\Entity\Bill;

class BillsController extends Controller {

    /**
     * @Route("/", name="list_bills")
     * @Route("/{year}", requirements={"year" = "\d{4}"}, name="list_bills_by_year")
     * @Route("/{type}", name="list_bills_by_type")
     * @Route("/{year}/{month}", requirements={"year"="\d{4}", "month"="\d{2}"}, name="list_bills_by_year_month")
     * @Route("/{year}/{month}/{template}", requirements={"year"="\d{4}", "month"="\d{2}"}, name="get_bill_by_year_month_template")
     * @return Response 
     */
    public function listAction(Request $request, $type = null, $year = null, $month = null, $template = null) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Bill");
        $args = array(
            'type' => $type,
            'year' => $year,
            'month' => $month,
            'template' => $template
        );
        if ($args['type']) {
            $records = $repository->findAllFilterByType($type);
        } else if ($args['year']) {
            $records = $repository->findAllByMonth($year . '%');
            if ($args['month']) {
                if ($args['template']) {
                    $record = $repository->findByMonthTemplate($year . '-' . $month . '%', $template);
                    return $this->render('PiquageBillsBundle:Bill:show.html.twig', array('record' => $record[0]));
                } else {
                    $records = $repository->findAllByMonth($year . '-' . $month . '%');
                }
            }
        } else {

            $activeBills = $this->getDoctrine()->getRepository('PiquageBillsBundle:BillTemplate')->findByActive(1);
            $records = $repository->findAllFilterByType('current');
            
            if (count($records) < count($activeBills)) {
                $this->createMissingBills($records);
                $records = $repository->findAllFilterByType('current');
                
            }
            $json = array();
            foreach($records as $r){
                $json[] = array('id' => $r->getID(),
//                    'name' => $r->getBillTemplate()->getNickname(),
                    'due' => $r->getDue()->format('Y-m-d')
                        );
            }
        
        }

   
        
        return $this->render('PiquageBillsBundle:Bill:index.html.twig', array('records' => $records));
    }

    /**
     * @Route("/grid/current", name="json_list_bills")
     * @return type
     */
    public function gridRequestAction() {
        
        $records = $this->getDoctrine()->getRepository('PiquageBillsBundle:Bill')->findAllFilterByType('current');

        $json = array();
        foreach ($records as $r) {
            $due = $r->getDue();
            $scheduled = $r->getScheduled();
            $paid = $r->getPaid();
            $cleared = $r->getCleared();
            $created = $r->getCreated();
            $updated = $r->getUpdated();
            
            
            $due = isset($due) ? $due->format('Y-m-d H:i:s') : "";
            $scheduled = isset($scheduled) ? $scheduled->format('Y-m-d H:i:s') : "";
            $paid = isset($paid) ? $paid->format('Y-m-d H:i:s') : "";
            $cleared = isset($cleared) ? $cleared->format('Y-m-d H:i:s') : "";
            $created = isset($created) ? $created->format('Y-m-d H:i:s') : "";
            $updated = isset($updated) ? $updated->format('Y-m-d H:i:s') : "";

            
            
            $json[] = array(
                'id'        => $r->getID(),
                'name'      => $r->getBillTemplate()->getNickname(),
                'amount'    => $r->getAmount(),
                'conf'      => $r->getConfNumber(),
                'due'       => $due,
                'scheduled' => $scheduled,
                'paid'      => $paid,
                'cleared'   => $cleared,
                'created'   => $created,
                'updated'   => $updated,
            );
        }


        $headers = array(
            'Content-Type' => 'application/json; charset=UTF-8'
        );

        $response = new Response(json_encode($json), 200, $headers);
       
        
        return $response;
    }
    
    /**
     * @Route("/show/{id}", requirements={"id"="\d+"}, name="show_bill")
     * @param type $id
     * @return Response 
     */
    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Bill");
        $record = $repository->findOneById($id);
        return $this->render('PiquageBillsBundle:Bill:show.html.twig', array('record' => $record));
    }

    /**
     * @Route("/new/bill", name="new_bill")
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="edit_bill")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request, $id = null) {
        if ($id) {
            $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Bill");
            $record = $repository->findOneById($id);
            $button = 'Update';
        } else {
            $record = new Bill();
            $button = 'Add';
        }

        $form = $this->createForm(new BillType(), $record);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                echo "form is valid<br/>";
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($record);
                $em->flush();

//                return $this->redirect($this->generateUrl('list_bills'));
            }
        }

        return $this->render('PiquageBillsBundle:Bill:new.html.twig', array(
                    'form' => $form->createView(),
                    'button' => $button,
                ));
    }

    /**
     * @Route("/{id}/delete", name="delete_bill")
     * @return Response 
     */
    public function removeAction($id) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Bill");
        $record = $repository->findOneById($id);

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($record);
        $em->flush();

        return $this->redirect($this->generateUrl('list_bills'));
    }

    private function createMissingBills() {
        $activeBillTemplates = $this->getDoctrine()->getRepository('PiquageBillsBundle:BillTemplate')->findByActive(1);
        
        foreach($activeBillTemplates as $ab){
            $this->getDoctrine()->getRepository('PiquageBillsBundle:Bill')->insertNext($ab);
        }

    }

    
    

}

