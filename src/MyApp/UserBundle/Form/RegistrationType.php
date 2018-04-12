<?php

namespace MyApp\UserBuilde\Form;
use Symfony\Component\Form\Test\FormBuilderInterface;

class RegistrationType extends AbstractType{
public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
{
    $builder
    ->add('nom')
    ->add('prenom')
;
}

public function getParent()
{
return 'fos_user_registration';
}

public function getName(){
return 'jtc_user_registration';
}

}