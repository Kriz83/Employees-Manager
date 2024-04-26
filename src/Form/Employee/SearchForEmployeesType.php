<?php

declare(strict_types=1);

namespace App\Form\Employee;

use App\Repository\EmployeeRepository;
use Symfony\Component\Form\AbstractType;
use App\Service\Convert\ConvertDataService;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchForEmployeesType extends AbstractType
{
    public const DEFAULT_MIN_BORN_DATE = '2000-01-01';

    public function __construct(
        private ConvertDataService $convert,
        private EmployeeRepository $employeeRepository,
    ) {
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                    'years' => range($this->getMinBornDate(), $this->getMaxBornDate()),
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
                    'years' => range($this->getMinBornDate(), $this->getMaxBornDate()),
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

    private function getMinBornDate(): ?string
    {
        $minBornDate = $this->employeeRepository->getMinBornDate();

        if ($minBornDate) {
            $minBornDate = $this->convert
                ->convertDateStringToDatetimeObject(
                    $minBornDate['minBornDate'] ?: self::DEFAULT_MIN_BORN_DATE
                );

            return $minBornDate->format('Y');
        }

        return "date('Y') + 1";
    }

    private function getMaxBornDate(): ?string
    {
        $maxBornDate = $this->employeeRepository->getMaxBornDate();

        if ($maxBornDate) {
            $maxBornDate = $this->convert
                ->convertDateStringToDatetimeObject(
                    $maxBornDate['maxBornDate'] ?: self::DEFAULT_MIN_BORN_DATE
                );

            return $maxBornDate->format('Y');
        }

        return "date('Y') + 1";
    }
}
