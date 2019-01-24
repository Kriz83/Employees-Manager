<?php

namespace App\Form\ContractType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddContractTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:13px; margin-bottom:5px; border: 2px solid rgb(100, 97, 97); width:250px; height:33px'),
                    'label' => 'ContractType Name :',
                    'required' => true,
                
                )
            )
            ->add('Add contract type', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
