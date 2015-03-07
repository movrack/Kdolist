<?php

namespace KDO\Bundle\KDOBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use KDO\Bundle\KDOBundle\Entity\Gift;
use KDO\Bundle\KDOBundle\Entity\Lists;
use KDO\Bundle\KDOBundle\Form\GiftType;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Gift controller.
 *
 * @Route("/gift")
 */
class GiftController extends Controller
{

    /**
     * Lists all Gift entities.
     *
     * @Route("/", name="gift")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('KDOKDOBundle:Gift')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Gift entity.
     *
     * @Route("/", name="gift_create")
     * @Method("POST")
     * @Template("KDOKDOBundle:Gift:edit.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Gift();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->getPicture()->preUpload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getList()->getId())));
        }

        return array(
            'action' => "new",
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Gift entity.
     *
     * @param Gift $entity The entity
     * @ParamConverter("entity", class="KDOKDOBundle:Gift")
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Gift $entity)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $form = $this->createForm(new GiftType($user), $entity, array(
            'action' => $this->generateUrl('gift_create'),
            'method' => 'POST',
        ));


        return $form;
    }



    /**
     * Displays a form to create a new Gift entity.
     *
     * @Route("/new/{list}", name="gift_new")
     * @ParamConverter("list", class="KDOKDOBundle:Lists")
     * @Method("GET")
     * @Template("KDOKDOBundle:Gift:edit.html.twig")
     */
    public function newAction(Lists $list)
    {
        $entity = new Gift();
        $entity->setList($list);
        $form   = $this->createCreateForm($entity);

        return array(
            'action' => "new",
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Gift entity.
     *
     * @Route("/{id}", name="gift_show")
     * @ParamConverter("Gift", class="KDOKDOBundle:Gift")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Gift $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gift entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Gift entity.
     *
     * @Route("/{id}/edit", name="gift_edit")
     * @Method("GET")
     * @ParamConverter("type", class="KDOKDOBundle:Gift")
     * @Template()
     */
    public function editAction(Gift $entity)
    {

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gift entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'action' => "edit",
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Gift entity.
    *
    * @param Gift $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Gift $entity)
    {

        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new GiftType($user), $entity, array(
            'action' => $this->generateUrl('gift_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Gift entity.
     *
     * @Route("/{id}", name="gift_update")
     * @ParamConverter("type", class="KDOKDOBundle:Gift")
     * @Method("PUT")
     * @Template("KDOKDOBundle:Gift:edit.html.twig")
     */
    public function updateAction(Request $request, Gift $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gift entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        // Todo Why is not working ?
        if ($editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity->getPicture()->preUpload();
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'entity.updated.success');

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getList()->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.updated.error');
        }

        return array(
            'action' => "edit",
            'entity' => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Gift entity.
     *
     * @Route("/{id}", name="gift_delete")
     * @ParamConverter("type", class="KDOKDOBundle:Gift")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Gift $entity)
    {
        $form = $this->createDeleteForm($entity->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gift entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'entity.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.delete.error');
        }

        return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getList()->getId())));

    }

    /**
     * Creates a form to delete a Gift entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gift_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
