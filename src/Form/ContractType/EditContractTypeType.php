<?php

namespace App\Form\ContractType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditContractTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'label' => 'ContractType Name :',
                    'required' => true,
                
                )
            )
            ->add('Change contract type data', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
