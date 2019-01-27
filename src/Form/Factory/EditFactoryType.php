<?php

namespace App\Form\Factory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditFactoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'label' => 'Factory Name :',
                    'required' => true,
                
                )
            )
            ->add(
                'address', TextType::class, array(
                    'label' => 'Address :',
                    'required' => true,
                
                )
            )
            ->add('Change factory data', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
