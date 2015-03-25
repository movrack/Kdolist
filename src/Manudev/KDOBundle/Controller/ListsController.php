<?php

namespace Manudev\KDOBundle\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use Manudev\UserBundle\Entity\User;
use Manudev\KDOBundle\Entity\Lists;
use Manudev\KDOBundle\Form\ListsType;
use Manudev\KDOBundle\Form\SubListsType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Lists controller.
 *
 * @Route("/lists")
 */
class ListsController extends Controller
{
    /**
     * @var User
     */
    private $user;
    
    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;
    
    /**
     * @DI\InjectParams({
     *     "securityContext" = @DI\Inject("security.context")
     * })
     */
    function __construct($securityContext)
    {
        $this->user = $securityContext->getToken()->getUser();
    }
    
    
    /**
     * Lists all Lists entities.
     *
     * @Route("/", name="lists")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entities = $this->em->getRepository('ManudevKDOBundle:Lists')->listForUser($this->user);
        return array(
            'entities' => $entities
        );
    }



    /**
     * Displays a form to create a new Lists entity.
     *
     * @Route("/new", name="lists_new")
     * @Method("GET")
     * @Template("ManudevKDOBundle:Lists:edit.html.twig")
     */
    public function newAction()
    {
        $entity = new Lists();
        $form   = $this->createCreateForm($entity);

        return array(
            'action' => "new",
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Lists entity.
     *
     * @Route("/", name="lists_create")
     * @Method("POST")
     * @Template("ManudevKDOBundle:Lists:edit.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lists();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->addUser($this->user);

            $this->em->persist($entity);
            $this->em->flush();

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        }

        return array(
            'action' => "new",
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Creates a new Lists entity.
     *
     * @Route("/subList/{parent_id}", name="lists_create_sublist")
     * @ParamConverter("parentList", class="ManudevKDOBundle:Lists", options={"id" = "parent_id"})
     * @Method("POST")
     * @Template("ManudevKDOBundle:Lists:editSubList.html.twig")
     */
    public function createSubListAction(Request $request, Lists $parentList)
    {
        $entity = new Lists();
        $form = $this->createSubListCreateForm($entity, $parentList);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $entity->addUser($this->user);
            $parentList->addChild($entity);
            $entity->setParent($parentList);

            $this->em->persist($parentList);
            $this->em->persist($entity);
            $this->em->flush();

            $this->get('session')->getFlashBag()->add('success', 'entity.delete.success');
            if($entity->getExternalListLink() != "") {
                return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getParent()->getId())));
            }
            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.delete.error');
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
        $form = $this->createForm(new ListsType($this->user), $entity, array(
            'action' => $this->generateUrl('lists_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a form to create a Lists entity.
     *
     * @param Lists $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSubListCreateForm(Lists $entity, Lists $parentList)
    {
        $form = $this->createForm(new SubListsType(), $entity, array(
            'action' => $this->generateUrl('lists_create_sublist', array('parent_id' => $parentList->getId())),
            'method' => 'POST',
        ));

        return $form;
    }


    /**
     * Displays a form to create a new Lists entity.
     *
     * @Route("/sublistnew/{parent_id}", name="lists_new_sublist")
     * @ParamConverter("parentList", class="ManudevKDOBundle:Lists", options={"id" = "parent_id"})
     * @Method("GET")
     * @Template("ManudevKDOBundle:Lists:editSubList.html.twig")
     */
    public function newSubListAction(Lists $parentList )
    {
        $entity = new Lists();
        $entity->setParent($parentList);
        $form   = $this->createSubListCreateForm($entity, $parentList);

        return array(
            'action' => "new",
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
    public function showAction(Lists $entity)
    {

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $parents = $this->em->getRepository('ManudevKDOBundle:Lists')->parents($entity);

        return array(
            'entity'    => $entity,
            'parents'   => $parents
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
        $form = $this->createForm(new ListsType($this->user), $entity, array(
            'action' => $this->generateUrl('lists_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a form to edit a Lists entity.
     *
     * @param Lists $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSubListEditForm(Lists $entity)
    {
        $form = $this->createForm(new SubListsType(), $entity, array(
            'action' => $this->generateUrl('lists_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        return $form;
    }



    /**
     * Edits an existing Lists entity.
     *
     * @Route("/{id}", name="lists_update")
     * @Template("ManudevKDOBundle:Lists:edit.html.twig")
     * @Method("POST")
     */
    public function updateAction(Request $request, Lists $entity)
    {

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $deleteForm = $this->createDeleteForm($entity);
        if($entity->getParent() != null) {
            $editForm = $this->createSubListEditForm($entity);
        } else {
            $editForm = $this->createEditForm($entity);
        }
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

            $this->em->persist($entity);
            $this->em->flush();

            $this->get('session')->getFlashBag()->add('success', 'entity.delete.success');
            if($entity->getExternalListLink() != "") {
                return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getParent()->getId())));
            }
            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.delete.error');
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
    public function editAction(Lists $entity)
    {

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createEditForm($entity);

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
     * @Route("/{id}/editSubList", name="lists_edit_sublist")
     * @Template()
     */
    public function editSubListAction(Lists $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createSubListEditForm($entity);

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
    private function createDeleteForm(Lists $list)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lists_delete', array('id' => $list->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Deletes a Lists entity.
     *
     * @Route("/{id}", name="lists_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lists $list)
    {
        $form = $this->createDeleteForm($list);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $list = $this->em->getRepository('ManudevKDOBundle:Lists')->find($list->getId());

            if (!$list) {
                throw $this->createNotFoundException('Unable to find Lists entity.');
            }

            foreach( $list->getOwners() as $owner) {
                $list->getOwners()->removeElement($owner);
                $this->em->remove($owner);
                $this->em->flush();
            }

            $parent = $list->getParent();
            $list->setParent(null);
            $this->em->remove($list);
            $this->em->flush();
            $this->get('session')->getFlashBag()->add('success', 'entity.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.delete.error');
        }

        if ($parent != null) {
            return $this->redirect($this->generateUrl('lists_show', array('id' => $parent->getId())));
        }
        return $this->redirect($this->generateUrl('lists'));
    }
}
