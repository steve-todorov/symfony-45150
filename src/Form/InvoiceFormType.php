<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Constraints;

class InvoiceFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', NumberType::class, array('label' => 'Client ID', 'required' => true))
            ->add('transactionNumber')
            // Throws InvalidArgumentException: Unreachable field "payments" in tests.
            ->add('payments', CollectionType::class, [
                'entry_type' => PaymentFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'error_bubbling' => false,
                'constraints' => [
                    new Constraints\Count(['min' => 1]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => null, 'error_bubbling' => false]);
    }

    public function getBlockPrefix()
    {
        return 'invoice_form';
    }

}
