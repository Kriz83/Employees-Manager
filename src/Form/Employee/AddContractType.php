<?php

namespace App\Form\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'factory', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Factory :',
                    'required' => true,
                
                )
            )
            ->add(
                'position', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Position :',
                    'required' => true,
                
                )
            )
            ->add(
                'startDate', DateType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:17px; margin: 0; padding-top: 0; padding-bottom: 0; border: 2px solid rgb(100, 97, 97); width:250px; height:40px'),
                    'label' => 'Start date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
                )
            )
            ->add(
                'stopDate', DateType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:17px; margin: 0; padding-top: 0; padding-bottom: 0; border: 2px solid rgb(100, 97, 97); width:250px; height:40px'),
                    'label' => 'Stop date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
                )
            )
            ->add('Add contract', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
