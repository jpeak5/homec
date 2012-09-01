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

//    /**
//     * @Route("/bill/create")
//     * @return type 
//     */
//    public function createAction() {
//        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:BillTemplate");
//
//        $billTemplate = $repository->findOneByNickname('vespa');
//
//        $bill = new Bill();
//        $bill->setAmount(72.34);
//        $bill->setBillTemplate($billTemplate);
//        $bill->setCleared(null);
//        $bill->setConfNumber(null);
//        $bill->setDue(new \DateTime('8/01/2012'));
//        $bill->setPaid(null);
//        $bill->setScheduled(null);
//
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->persist($bill);
////        $em->persist($billTemplate);
//        $em->flush();
//
//        return $this->render('PiquageBillsBundle:Default:bills.html.twig', array(
//                    'bill' => $bill,
//                    'billTemplate' => $billTemplate,
//                    'biller' => $billTemplate->getBiller()
//                ));
//    }

    /**
     * @Route("/", name="list_bills")
     * @Route("/{year}", requirements={"year" = "\d{4}"}, name="list_bills_by_year")
     * @Route("/{type}", name="list_bills_by_type")
     * @Route("/{year}/{month}", requirements={"year"="\d{4}", "month"="\d{2}"}, name="list_bills_by_year_month")
     * @Route("/{year}/{month}/{template}", requirements={"year"="\d{4}", "month"="\d{2}"}, name="get_bill_by_year_month_template")
     * @return Response 
     */
    public function listAction(Request $request, $type=null, $year=null, $month=null, $template=null) {
        $repository = $this->getDoctrine()->getRepository("PiquageBillsBundle:Bill");
        $args = array(
            'type'=>$type,
            'year'=>$year,
            'month'=>$month,
            'template'=>$template
        );
        if($args['type']){
            $records = $repository->findAllFilterByType($type);
            
            }else if($args['year']){
            $records = $repository->findAllByMonth($year.'%');
            if($args['month']){
                if($args['template']){
                    $record = $repository->findByMonthTemplate($year.'-'.$month.'%', $template);
                    return $this->render('PiquageBillsBundle:Bill:show.html.twig', array('record'=>$record[0]));
                }else{
                    $records = $repository->findAllByMonth($year.'-'.$month.'%');
                }
            }
        }else{
            //list all
            $records = $repository->findAll();
        }
        
        
        return $this->render('PiquageBillsBundle:Bill:index.html.twig', array('records' => $records));
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

}   