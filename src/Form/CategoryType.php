<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'Nom de la catégorie',
                    'required' => true,
                    'attr' =>
                        [
                            'class' => 'form-control',
                        ],
                ])
            ->add('media', FileType::class,
                [
                    'label' => 'Média de la catégorie',
                    'mapped' => false,
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control',
                        ],
                    'constraints' => [
                        new File(
                            [
                                'maxSize' => '1024k',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                    'image/webp',
                                ],
                                'mimeTypesMessage' => 'Veuillez choisir une image JPG, PNG ou WebP',
                            ]
                        )
                    ],
                ]
            )
            ->add('isOnline', CheckboxType::class,
                [
                    'label' => 'Afficher sur le site',
                    'required' => false,
                    'attr' =>
                        [
                            'class' => 'form-control',
                        ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
