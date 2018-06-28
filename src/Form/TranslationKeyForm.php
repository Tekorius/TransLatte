<?php

namespace App\Form;

use App\Entity\TranslationFile;
use App\Entity\TranslationKey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TranslationKeyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()]
            ])
            ->add('description', TextareaType::class)
            ->add('file', EntityType::class, [
                'class' => TranslationFile::class,
                'constraints' => [new NotBlank()]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TranslationKey::class,
            'csrf_protection' => false,
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['name', 'file']
                ]),
            ]
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
