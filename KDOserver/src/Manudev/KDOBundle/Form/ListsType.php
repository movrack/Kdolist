<?php

namespace Manudev\KDOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Manudev\CoreBundle\Form\PictureType;
use Manudev\UserBundle\Entity\User;
use Manudev\UserBundle\Repository\BankAccountRepository;

class ListsType extends AbstractType
{
    /**
     * @var \Manudev\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @param \Manudev\UserBundle\Entity\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subTitle')
            ->add('event')
            ->add('description', 'textarea')
            ->add('isPublic')
            ->add('picture', new PictureType())

            ->add('owners', 'collection',
                array(
                    'type' => new ListOwnerType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                )
            )
            ->add('bankaccount', 'entity', array(
                'class' => 'ManudevUserBundle:BankAccount',
                'property' => 'number',
                'required' => false,
                'query_builder' => function(BankAccountRepository $er) {
                    return $er->findForUserQueryBuilder($this->user);
                },

                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Manudev\KDOBundle\Entity\Lists'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kdo_bundle_kdobundle_lists';
    }


}
