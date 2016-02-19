<?php
/**
 * Created by PhpStorm.
 * User: sylva
 * Date: 03/02/2016
 * Time: 16:57
 */

namespace bundle\FrontBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;



class ProfileFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('adresse')
            ->add('telephone')
            ->add('siteWeb')

        ;
    }

    public function getBlockPrefix()
    {
        return 'edit_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}