<?php

namespace App\Form;

use App\Entity\Translation;
use App\Entity\TranslationKey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TranslationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locale', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Locale(),
                ],
            ])
            ->add('translationKey', EntityType::class, [
                'class' => TranslationKey::class,
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('value', TextareaType::class, [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('description', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Translation::class,
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
