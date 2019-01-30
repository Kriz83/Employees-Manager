<?php

namespace App\Form\Annex;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddAnnexType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {    

        $builder 
            ->add('bidValue' , MoneyType::class, array(
                    'label' => 'Bid value :',
                    'required' => true,
                    'data' => null,
            ))
            ->add(
                'startDate', DateType::class, array(
                    'label' => 'Start date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(date('Y'), date('Y') + 5),
                    'required' => true,
                    'data' => null,
            ))
            ->add(
                'signDate', DateType::class, array(
                    'label' => 'Sing date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(date('Y'), date('Y') + 5),
                    'required' => true,
                    'data' => null,
            ))          
            ->add('Add annex', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
            )));
        
    }
}
