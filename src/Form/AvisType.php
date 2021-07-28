<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez écrire un objet ',
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'style' => 'height: 150px',
                    'placeholder' => 'Ecrire ici votre message',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ne pas envoyer un message vide',
                    ]),
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Veuillez écrire pour ne pas envoyer de message vide',
                        'max' => 200,
                        'maxMessage' => 'Le message ne doit pas dépasser 200 caractères',
                        // max length allowed by Symfony for security reasons
                        // 'max' => 4096,
                    ]),
                ],
            ])

            ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
