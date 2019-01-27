<?php

namespace App\Form\Contract;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Service\Convert\ConvertDataService;
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
    public function __construct(EntityManagerInterface $em, ConvertDataService $convert)
    {
        $this->em = $em;
        $this->convert = $convert;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
        $factoriesArray = $this->em->getRepository('App:Factory')->getToListArray();

        $positionsArray = $this->em->getRepository('App:Position')->getToListArray();

        $contractTypesArray = $this->em->getRepository('App:ContractType')->getToListArray();

        //get years range for search
        $maxStartDate = $this->em->getRepository('App:Contract')->getMaxStartDate();
        
        $minStartDate = $this->em->getRepository('App:Contract')->getMinStartDate();

        $maxStopDate = $this->em->getRepository('App:Contract')->getMaxStopDate();
        
        $minStopDate = $this->em->getRepository('App:Contract')->getMinStopDate();

        if ($maxStartDate) {
            $maxStartDate = $this->convert->convertDateStringToDatetimeObject($maxStartDate['maxStartDate']);
            $maxStartDate = $maxStartDate->format('Y');
        } else {
            $maxStartDate = "date('Y') + 1";
        }

        if ($minStartDate) {
            $minStartDate = $this->convert->convertDateStringToDatetimeObject($minStartDate['minStartDate']);
            $minStartDate = $minStartDate->format('Y');
        } else {
            $minStartDate = "date('Y') - 1";
        }

        if ($maxStopDate) {
            $maxStopDate = $this->convert->convertDateStringToDatetimeObject($maxStopDate['maxStopDate']);
            $maxStopDate = $maxStopDate->format('Y');
        } else {
            $maxStopDate = "date('Y') + 1";
        }

        if ($minStopDate) {
            $minStopDate = $this->convert->convertDateStringToDatetimeObject($minStopDate['minStopDate']);
            $minStopDate = $minStopDate->format('Y');
        } else {
            $minStopDate = "date('Y') - 1";
        }
        //end of dates range creating

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
                'startDateFrom', DateType::class, array(
                    'label' => 'Start date from:',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range($maxStartDate, $minStartDate),
                    'required' => false,
                    'data' => null,
                )
            )
            ->add(
                'startDateTo', DateType::class, array(
                    'label' => 'Start date to:',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range($maxStopDate, $minStopDate),
                    'required' => false,
                    'data' => null,
                )
            )
            ->add('Search', SubmitType::class, array(                
                'attr' => array(
                    'class' => 'btn-primary'
                )
            ));
        
    }
}
