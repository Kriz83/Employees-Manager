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
            ->add(
                'startDateFrom', DateType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:17px; margin: 0; padding-top: 0; padding-bottom: 0; border: 2px solid rgb(100, 97, 97); width:250px; height:40px'),
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
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'color:black; position: inherit; line-height: 0.3px; font-size:17px; margin: 0; padding-top: 0; padding-bottom: 0; border: 2px solid rgb(100, 97, 97); width:250px; height:40px'),
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
