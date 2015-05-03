<?php

namespace Manudev\KDOBundle\Form;

use Manudev\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Manudev\CoreBundle\Form\PictureType;

use Manudev\KDOBundle\Repository\ListsRepository;

class GiftType extends AbstractType
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
            ->add('name')
            ->add('list', 'entity', array(
                'class'=>'ManudevKDOBundle:Lists',
                'query_builder' => function(ListsRepository $er)  {
                    return $er->listForUserQueryBuilder($this->user, true);
                },
                'property' => 'listPath'
            ))
            ->add('picture')

            ->add('description', 'textarea')
            ->add('link')
            ->add('price')
            ->add('picture', new PictureType())
            ->add('giveMoney', 'checkbox', array(
                'required' => false
            ))
            ->add('accepteMultipleParts', 'checkbox', array(
                'required' => false
            ))
            ->add('numberOfParts', 'integer', array(
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Manudev\KDOBundle\Entity\Gift'
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
