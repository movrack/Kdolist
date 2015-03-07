<?php

namespace KDO\Bundle\KDOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubListsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subTitle')
            ->add('description')
            ->add('picture', new PictureType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KDO\Bundle\KDOBundle\Entity\Lists'
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
