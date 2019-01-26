<?php

namespace App\Form\Contract;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchForContractsType extends AbstractType
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
                        $factoriesArray,
                        '|-o-|' => null,),
                    'attr' => array(
                        'class' => 'form-control' , 'style' => 'color:black; font-size:14px; text-transform: uppercase; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'),
                    'label' => 'Factory :',
                    'required' => true,
                    'data' => null,
            ))
            ->add('position' , ChoiceType::class, array(
                    'choices' => array(
                        $positionsArray,
                        '|-o-|' => null,),
                    'attr' => array(
                        'class' => 'form-control' , 'style' => 'color:black; font-size:14px; text-transform: uppercase; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'),
                    'label' => 'Position :',
                    'required' => true,
                    'data' => null,
            ))
            ->add('contractType' , ChoiceType::class, array(
                    'choices' => array(
                        $contractTypesArray,
                        '|-o-|' => null,),
                    'attr' => array(
                        'class' => 'form-control' , 'style' => 'color:black; font-size:14px; text-transform: uppercase; margin-bottom:15px; border: 1px solid darkgreen; width:300px; height:40px'),
                    'label' => 'Contract type :',
                    'required' => true,
                    'data' => null,
            ))
            ->add('Search', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}