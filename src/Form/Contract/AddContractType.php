<?php

namespace App\Form\Contract;

use App\Entity\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddContractType extends AbstractType
{
    private $em;
    
    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
        $factoriesArray = $this->em
            ->getRepository('App:Factory')
            ->getToListArray();

        $positionsArray = $this->em
            ->getRepository('App:Position')
            ->getToListArray();

        $contractTypesArray = $this->em
            ->getRepository('App:ContractType')
            ->getToListArray();

        $builder
            ->add('factory' , ChoiceType::class, array(
                    'choices' => array(
                        $factoriesArray),
                    'attr' => array(
                        'class' => 'form-control' , 'style' => 'color:black; font-size:14px; text-transform: uppercase; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'),
                    'label' => 'Factory :',
                    'required' => true,
            ))
            ->add('position' , ChoiceType::class, array(
                    'choices' => array(
                        $positionsArray),
                    'attr' => array(
                        'class' => 'form-control' , 'style' => 'color:black; font-size:14px; text-transform: uppercase; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'),
                    'label' => 'Position :',
                    'required' => true,
            ))
            ->add('contractType' , ChoiceType::class, array(
                    'choices' => array(
                        $contractTypesArray),
                    'attr' => array(
                        'class' => 'form-control' , 'style' => 'color:black; font-size:14px; text-transform: uppercase; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'),
                    'label' => 'Contract type :',
                    'required' => true,
            ))
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
