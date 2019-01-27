<?php

namespace App\Form\Employee;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Service\Convert\ConvertDataService;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchForEmployeesType extends AbstractType
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
        
        $minBornDate = $this->em->getRepository('App:Employee')->getMinBornDate();
        $maxBornDate = $this->em->getRepository('App:Employee')->getMaxBornDate();

        if ($minBornDate) {
            $minBornDate = $this->convert->convertDateStringToDatetimeObject($minBornDate['minBornDate']);
            $minBornDate = $minBornDate->format('Y');
        } else {
            $minBornDate = "date('Y') + 1";
        }

        if ($maxBornDate) {
            $maxBornDate = $this->convert->convertDateStringToDatetimeObject($maxBornDate['maxBornDate']);
            $maxBornDate = $maxBornDate->format('Y');
        } else {
            $maxBornDate = "date('Y') + 1";
        }
           
        $builder
            ->add(
                'name', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'label' => 'Name :',
                    'required' => false,
                
                )
            )
            ->add(
                'surname', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'label' => 'Surname :',
                    'required' => false,
                )
            )
            ->add(
                'idDocumentNumber', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control', 
                    ),
                    'label' => 'Domument number :',
                    'required' => false,
                )
            )
            ->add(
                'bornDateFrom', DateType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'label' => 'Born date range from:',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range($minBornDate, $maxBornDate),
                    'required' => false,
                    'data' => null,
                )
            )
            ->add(
                'bornDateTo', DateType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                    'label' => 'Born date range to:',                    
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range($minBornDate, $maxBornDate),
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
