<?php

namespace KDO\Bundle\KDOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GiftType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('picture')
            ->add('link')
            ->add('price')
            ->add('isSecondHand', 'checkbox', array(
                'required' => false
            ))
            ->add('giveMoney', 'checkbox', array(
                'required' => false
            ))
            ->add('accepteMultipleParts', 'checkbox', array(
                'required' => false
            ))
            ->add('numberOfParts', 'integer', array(
                'required' => false
            ))
            ->add('list')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'KDO\Bundle\KDOBundle\Entity\Gift'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kdo_bundle_kdobundle_gift';
    }
}
