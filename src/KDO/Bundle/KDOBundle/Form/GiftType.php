<?php

namespace KDO\Bundle\KDOBundle\Form;

use KDO\Bundle\KDOBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

use KDO\Bundle\KDOBundle\Repository\ListsRepository;

class GiftType extends AbstractType
{
    /**
     * @var \KDO\Bundle\KDOBundle\Entity\User
     */
    protected $user;

    /**
     * @param \KDO\Bundle\KDOBundle\Entity\User $user
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
            ->add('list', 'entity', array(
                'class'=>'KDOKDOBundle:Lists',
                'query_builder' => function(ListsRepository $er)  {
                    return $er->listOfUserQueryBuilder($this->user);
                    //return $er->createQueryBuilder('u')
                    //    ->orderBy('u.username', 'ASC');
                }
            ))
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
