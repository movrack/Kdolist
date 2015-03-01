<?php

namespace KDO\Bundle\KDOBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use KDO\Bundle\KDOBundle\Entity\Lists;
use KDO\Bundle\KDOBundle\Form\ListsType;
use KDO\Bundle\KDOBundle\Entity\ListType;
use Doctrine\Common\Collections\ArrayCollection;

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
        $user = $this->get('security.context')->getToken()->getUser();
        $entities = $em->getRepository('KDOKDOBundle:Lists')->listOfUser($user);
        $listeTypes = $em->getRepository('KDOKDOBundle:ListType')->findAll();
        return array(
            'entities' => $entities,
            'listeTypes' => $listeTypes
        );
    }
    /**
     * Deletes a Formule entity.
     *
     * @return Response Twig response
     *
     * @Route("/delete")
     * @Method("POST")
     */
    public function delete2Action()
    {
        $entity_id = $this->getRequest()->get('id');
        $entity = $this->em->getRepository('EwFinanceBundle:Formule')->find($entity_id);
        $form = $this->createDeleteForm($entity->getId());
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $this->em->remove($entity);
            $this->em->flush();
            $this->get('session')->getFlashBag()->set('success', 'entity.delete.success');
        } else {
            $this->get('session')->getFlashBag()->set('error', 'entity.delete.error');
        }


        return $this->redirect($this->generateUrl('ew_finance_formule_index'));
    }

    /**
     * Deletes a Lists entity.
     *
     * @Route("/{id}", name="lists_delete")
     * @ParamConverter("type", class="KDOKDOBundle:Lists")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lists $list)
    {
        $form = $this->createDeleteForm($list->getId());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $list = $em->getRepository('KDOKDOBundle:Lists')->find($list->getId());

            if (!$list) {
                throw $this->createNotFoundException('Unable to find Lists entity.');
            }

            foreach( $list->getOwners() as $owner) {
                $list->getOwners()->removeElement($owner);
                $em->remove($owner);
                $em->flush();
            }

            $em->remove($list);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'entity.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.delete.error');
        }

        return $this->redirect($this->generateUrl('lists'));
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
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->addUser($user);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        }

        return array(
            'action' => "new",
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

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lists entity.
     *
     * @Route("/new/{id}", name="lists_new")
     * @ParamConverter("type", class="KDOKDOBundle:ListType")
     * @Method("GET")
     * @Template("KDOKDOBundle:Lists:edit.html.twig")
     */
    public function newAction(ListType $type)
    {
        $entity = new Lists();
        $entity->setType($type);
        $form   = $this->createCreateForm($entity);

        return array(

            'action' => "new",
            'entity' => $entity,
            'form'   => $form->createView(),
            'type' => $type
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
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }



    /**
     * Edits an existing Lists entity.
     *
     * @Route("/{id}", name="lists_update")
     * @Template("KDOKDOBundle:Lists:edit.html.twig")
     * @Method("POST")
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

            $originalOwners = new ArrayCollection();

            foreach ($entity->getOwners() as $owner) {
                $originalOwners->add($owner);
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    $owner->getFirstName()
                );
            }


            foreach ($originalOwners as $owner) {
                if ($entity->getOwners()->contains($owner) == false) {
                    $owner->getList()->removeElement($entity);
                }
            }

            $entity->getPicture()->preUpload();

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        }

        return array(
            'action' => "edit",
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lists entity.
     *
     * @Route("/{id}/edit", name="lists_edit")
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
            'action' => "edit",
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
            ->getForm();
        ;
    }
}
