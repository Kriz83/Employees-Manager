<?php

namespace App\Form\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Name :',
                    'required' => true,
                
                )
            )
            ->add(
                'surname', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Surname :',
                    'required' => true,
                )
            )
            ->add(
                'bornDate', DateType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:17px; margin: 0; padding-top: 0; padding-bottom: 0; border: 2px solid rgb(100, 97, 97); width:250px; height:40px'),
                    'label' => 'Born date :',                    
                    'widget' => 'choice',
                    'years' => range(date('Y')-16, date('Y')-100),
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
                )
            )
            ->add(
                'idDocumentNumber', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control', 
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'Domument number :',
                )
            )
            ->add('Add employee', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
