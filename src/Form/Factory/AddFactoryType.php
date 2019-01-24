<?php

namespace App\Form\Factory;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddFactoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Factory Name :',
                    'required' => true,
                
                )
            )
            ->add(
                'address', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Address :',
                    'required' => true,
                
                )
            )
            ->add('Add factory', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
