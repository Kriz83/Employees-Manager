<?php

namespace App\Form\Position;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditPositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'label' => 'Position Name :',
                    'required' => true,
                
                )
            )
            ->add(
                'description', TextType::class, array(
                    'label' => 'Description :',
                    'required' => true,
                
                )
            )
            ->add('Change position data', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
