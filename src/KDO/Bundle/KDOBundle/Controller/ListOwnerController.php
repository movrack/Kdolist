<?php

namespace KDO\Bundle\KDOBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use KDO\Bundle\KDOBundle\Entity\ListOwner;
use KDO\Bundle\KDOBundle\Form\ListOwnerType;

/**
 * ListOwner controller.
 *
 * @Route("/listowner")
 */
class ListOwnerController extends Controller
{

    /**
     * Lists all ListOwner entities.
     *
     * @Route("/", name="listowner")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KDOKDOBundle:ListOwner')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ListOwner entity.
     *
     * @Route("/", name="listowner_create")
     * @Method("POST")
     * @Template("KDOKDOBundle:ListOwner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ListOwner();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('listowner_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ListOwner entity.
     *
     * @param ListOwner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ListOwner $entity)
    {
        $form = $this->createForm(new ListOwnerType(), $entity, array(
            'action' => $this->generateUrl('listowner_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ListOwner entity.
     *
     * @Route("/new", name="listowner_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ListOwner();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ListOwner entity.
     *
     * @Route("/{id}", name="listowner_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KDOKDOBundle:ListOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListOwner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ListOwner entity.
     *
     * @Route("/{id}/edit", name="listowner_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KDOKDOBundle:ListOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListOwner entity.');
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
    * Creates a form to edit a ListOwner entity.
    *
    * @param ListOwner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ListOwner $entity)
    {
        $form = $this->createForm(new ListOwnerType(), $entity, array(
            'action' => $this->generateUrl('listowner_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ListOwner entity.
     *
     * @Route("/{id}", name="listowner_update")
     * @Method("PUT")
     * @Template("KDOKDOBundle:ListOwner:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KDOKDOBundle:ListOwner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListOwner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('listowner_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ListOwner entity.
     *
     * @Route("/{id}", name="listowner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('KDOKDOBundle:ListOwner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ListOwner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('listowner'));
    }

    /**
     * Creates a form to delete a ListOwner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('listowner_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
