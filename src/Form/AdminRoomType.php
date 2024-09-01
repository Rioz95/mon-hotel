<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AdminRoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type de chambre',
                'attr' => [
                    'placeholder' => "Entrer le type de vore chambre"
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Categorie',
                'class' => Category::class,
                'choice_label' => 'name', // Le champ de l'entité à afficher dans la liste déroulante
                'placeholder' => 'Choisissez un type', // Texte par défaut
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Enter a Description'
                ]
            ])
            ->add(
                'price',
                MoneyType::class,
                [
                    'label' => 'price',
                    'attr' => [
                        'placeholder' => 'Enter the price for your room'
                    ]
                ]
            )
            ->add('adult', ChoiceType::class, [
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '4+' => 5, // Valeur numérique derrière le choix "4+"
                ],
                'expanded' => false, // Liste déroulante (false), sinon cases à cocher
                'multiple' => false, // Une seule option peut être sélectionnée
            ])
            ->add('child', ChoiceType::class, [
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '4+' => 5, // Valeur numérique derrière le choix "4+"
                ],
                'expanded' => false, // Liste déroulante (false), sinon cases à cocher
                'multiple' => false, // Une seule option peut être sélectionnée
            ])
            ->add('image', HiddenType::class, [
                'label' => "l'image de l'appartement",
                'attr' => [
                    'placeholder' => 'entrer une image qui donne envie'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'label' => 'Ajouter une image qui donner vraiment envie',
                'attr' => [
                    'accept' => ".jpg, .png"
                ],
                'row_attr' => [
                    'class' => 'd-none',
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => '40048k',
                        'maxSizeMessage'  => "La taille maximum doit être égal à 2048k",
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ]
                    ])
                ]
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
