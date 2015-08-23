<?php

namespace Manudev\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


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
            ->add('number')
            ->add('description')
            ->add('beneficiary1')
            ->add('beneficiary2')
            ->add('beneficiary3')
            ->add('beneficiary4')
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
