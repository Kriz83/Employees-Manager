<?php

namespace App\Form\Contract;

use App\Repository\ContractTypeRepository;
use App\Repository\FactoryRepository;
use App\Repository\PositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddContractType extends AbstractType
{
    public function __construct(
        private EntityManagerInterface $em,
        private FactoryRepository $factoryRepository,
        private PositionRepository $positionRepository,
        private ContractTypeRepository $contractTypeRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
        $factoriesArray = $this->factoryRepository
            ->getToListArray();

        $positionsArray = $this->positionRepository
            ->getToListArray();

        $contractTypesArray = $this->contractTypeRepository
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
            ->add('bidValue' , MoneyType::class, array(
                    'label' => 'Bid value :',
                    'required' => true,
                    'data' => null,
            ))
            ->add('factory' , ChoiceType::class, array(
                    'choices' => array(
                        $factoriesArray,
                        '|-o-|' => null,),
                    'label' => 'Factory :',
                    'required' => true,
                    'data' => null,
            ))
            ->add(
                'startDate', DateType::class, array(
                    'label' => 'Start date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => true,
                    'data' => null,
            ))
            ->add(
                'stopDate', DateType::class, array(
                    'label' => 'Stop date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'required' => false,
                    'data' => null,
            ))
            ->add(
                'signDate', DateType::class, array(
                    'label' => 'Sing date :',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(date('Y'), date('Y')+1),
                    'required' => true,
                    'data' => null,
            ))
            ->add('add_contract', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary'
            )));
        
    }
}
