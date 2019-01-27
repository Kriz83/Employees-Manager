<?php

namespace App\Form\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'label' => 'Name :',
                    'required' => true,
                
                )
            )
            ->add(
                'surname', TextType::class, array(
                    'label' => 'Surname :',
                    'required' => true,
                )
            )
            ->add(
                'bornDate', DateType::class, array(
                    'label' => 'Born date :',                    
                    'widget' => 'choice',
                    'years' => range(date('Y')-16, date('Y')-100),
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
                )
            )
            ->add(
                'idDocumentNumber', TextType::class, array(
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
