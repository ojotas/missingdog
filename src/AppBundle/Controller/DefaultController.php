<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Pet;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Row;
use AppBundle\Form\PetType;


class DefaultController extends Controller
{
    /**
     * @Route("/index", name="pet_homepage")
     */
    public function indexAction()
{
       return $this->render(':AppBundle:index.html.twig');
}
    /**
     * @Route("/new", name="pet_new")
     * @Method("GET|POST")
     */
    public function createAction(Request $request)
{
    $pet = new Pet();
    $form = $this->createForm(PetType::class, $pet);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $pet->setFound(false);
        $em->persist($pet);
        $em->flush();
        $this->addFlash(
            'notice',
            'Pet succesfully added'
        );
        return $this->redirect($this->generateUrl(
            'pet_list'           
                ));
    }
    
    return $this->render(':AppBundle:new.html.twig', [
            'form' => $form->createView()
]);
    

    
}
   /**
     * @Route("/list", name="pet_list")
     * @Template("list.html.twig")
     * 
     */
    public function myGridAction()
    {
        $source = new Entity('AppBundle:Pet');
        $grid = $this->get('grid');
        $grid->setSource($source);
        $title='';
        $route='';
        $rowAction = new RowAction($title,$route);
        $rowAction->manipulateRender(function ($action, $row) {
            if (($row->getField('found') != true)) {
                $action->setTitle('Mark as found');
                $action->setRoute('pet_found');
            } else { return null; }
           
            return $action;
        });
        
        
        
        $grid->addRowAction($rowAction);
        $grid->addRowAction(new RowAction('Delete', 'pet_delete', true));
        $grid->setActionsColumnSize(150);
        
        return $grid->getGridResponse(':AppBundle:list.html.twig');
        
    }
    
    /**
     * Deletes a Pet entity.
     *
     * @Route("/delete/{id}", name="pet_delete")
     * @Method("DELETE|GET")
     */
    public function deleteAction(Pet $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $pet = $em->getRepository('AppBundle:Pet')->findById($entity->getId());
        $em->remove($pet[0]);
        $em->flush();

        $this->addFlash(
            'notice',
            'Pet deleted'
        );
        return $this->redirect($this->generateUrl(
            'pet_list'           
                ));
    }
    
    /**
     * 
     *
     * @Route("/found/{id}", name="pet_found")
     * @Method("DELETE|GET")
     */
    public function foundAction(Pet $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $pet = $em->getRepository('AppBundle:Pet')->findById($entity->getId());
        $pet[0]->setFound(true);
        $em->persist($pet[0]);
        $em->flush();

        $this->addFlash(
            'notice',
            'Pet found!'
        );
        return $this->redirect($this->generateUrl(
            'pet_list'           
                ));
    }
    
}
