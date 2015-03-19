<?php

namespace Manudev\UserBundle\Form;

use Manudev\UserBundle\Entity\BankAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

use Manudev\KDOBundle\Repository\ListsRepository;

class BankAccountType extends AbstractType
{
    /**
     * @var \Manudev\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('number', 'number')
            ->add('description')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Manudev\UserBundle\Entity\BankAccount'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kdo_bundle_kdobundle_bankaccount';
    }
}
