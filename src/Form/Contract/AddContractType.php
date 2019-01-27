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
                        $factoriesArray,
                        '|-o-|' => null,),
                    'label' => 'Factory :',
                    'required' => true,
                    'data' => null,
            ))
            ->add('position' , ChoiceType::class, array(
                    'choices' => array(
                        $positionsArray,
                        '|-o-|' => null,),
                    'label' => 'Position :',
                    'required' => true,
                    'data' => null,
            ))
            ->add('contractType' , ChoiceType::class, array(
                    'choices' => array(
                        $contractTypesArray,
                        '|-o-|' => null,),
                    'label' => 'Contract type :',
                    'required' => true,
                    'data' => null,
            ))
            ->add(
                'startDate', DateType::class, array(
                    'label' => 'Start date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
                )
            )
            ->add(
                'stopDate', DateType::class, array(
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
