<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '100'
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '9',
                    'maxlength' => '16'
                ],
                'label' => 'Numero de telephone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 9, 'max' => 16]),
                    new Assert\NotBlank()
                ]

            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                ]

            ])
            ->add('name_entreprise', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => false,
                'label' => "Nom de l'entreprise où travaille la personne",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [

                ]

            ])
            ->add('poste', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Poste occupé par la personne',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                ]

            ])
            ->add('birthdate', DateType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                // 'widget' => 'single_text',
                // 'format' => 'dd/MM/yyyy',
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    // new Assert\Date(),
                    // new Assert\LessThanOrEqual("today")
                ]

            ])
            ->add('notes', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'label' => 'Notes concernant cette personne',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 mb-2'
                ],
                'label' => 'Enregistrer le contact'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
