<?php

namespace App\Form\Contract;

use App\Entity\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditContractType extends AbstractType
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
            ))
            ->add('position' , ChoiceType::class, array(
                    'choices' => array(
                        $positionsArray,
                        '|-o-|' => null,),
                    'label' => 'Position :',
                    'required' => true,
            ))
            ->add('contractType' , ChoiceType::class, array(
                    'choices' => array(
                        $contractTypesArray,
                        '|-o-|' => null,),
                    'label' => 'Contract type :',
                    'required' => true,
            ))
            ->add('bidValue' , MoneyType::class, array(
                    'label' => 'Bid value :',
                    'required' => true,
            ))
            ->add('factory' , ChoiceType::class, array(
                    'choices' => array(
                        $factoriesArray,
                        '|-o-|' => null,),
                    'label' => 'Factory :',
                    'required' => true,
            ))
            ->add(
                'startDate', DateType::class, array(
                    'label' => 'Start date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
            ))
            ->add(
                'stopDate', DateType::class, array(
                    'label' => 'Stop date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => false,
            ))
            ->add(
                'signDate', DateType::class, array(
                    'label' => 'Sing date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(date('Y'), date('Y')+1),
                    'required' => true,
            ))
            ->add('active' , ChoiceType::class, array(
                    'choices' => array(
                        'Yes' => true,
                        'No' => false,),
                    'label' => 'Active :',
            ))
            ->add('Change contract', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
            )));
        
    }
}
