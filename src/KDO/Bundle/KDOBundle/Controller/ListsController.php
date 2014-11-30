<?php

namespace KDO\Bundle\KDOBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use KDO\Bundle\KDOBundle\Entity\Lists;
use KDO\Bundle\KDOBundle\Form\ListsType;

/**
 * Lists controller.
 *
 * @Route("/lists")
 */
class ListsController extends Controller
{

    /**
     * Lists all Lists entities.
     *
     * @Route("/", name="lists")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KDOKDOBundle:Lists')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Lists entity.
     *
     * @Route("/", name="lists_create")
     * @Method("POST")
     * @Template("KDOKDOBundle:Lists:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lists();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Lists entity.
     *
     * @param Lists $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lists $entity)
    {
        $form = $this->createForm(new ListsType(), $entity, array(
            'action' => $this->generateUrl('lists_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lists entity.
     *
     * @Route("/new", name="lists_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lists();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Lists entity.
     *
     * @Route("/{id}", name="lists_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KDOKDOBundle:Lists')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lists entity.
     *
     * @Route("/{id}/edit", name="lists_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KDOKDOBundle:Lists')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Lists entity.
    *
    * @param Lists $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lists $entity)
    {
        $form = $this->createForm(new ListsType(), $entity, array(
            'action' => $this->generateUrl('lists_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Lists entity.
     *
     * @Route("/{id}", name="lists_update")
     * @Method("PUT")
     * @Template("KDOKDOBundle:Lists:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KDOKDOBundle:Lists')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lists_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Lists entity.
     *
     * @Route("/{id}", name="lists_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KDOKDOBundle:Lists')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lists entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lists'));
    }

    /**
     * Creates a form to delete a Lists entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lists_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
