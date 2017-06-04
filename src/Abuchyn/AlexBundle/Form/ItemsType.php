<?php

namespace Abuchyn\AlexBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ItemsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Тема']])
            ->add('image', FileType::class,
                [
                    'label' => 'Фото заголовка',
                    'attr' =>
                        [
                            'placeholder' => 'Статья',
                            'accept' => 'image/*'
                        ],
                    'data_class' => null
                ])
            ->add('author', TextType::class,
                [
                    'label' => false,
                    'attr' =>
                        [
                            'placeholder' => 'Автор',
                            'Value' => 'Alexey Buchyn'
                        ]
                ])
            ->add('blog', CKEditorType::class, [
                'label' => false,
                'config' => [
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => [
                        'instance' => 'default',
                        'homeFolder' => ''
                    ]
                ],
            ])
            ->add('tags', TextType::class,
                [
                    'label' => false,
                    'attr' =>
                        [
                            'placeholder' => 'Теги',
                        ],
                    'data_class' => null
                ])
            ->add('category', ChoiceType::class,
                [
                    'label' => false,
                    'choices' =>
                        [
                            'Категория' =>
                                [
                                    'Фото' => 'photo_bg',
                                    'Наука' => 'science_bg'
                                ]
                        ]
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Abuchyn\AlexBundle\Entity\Items'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'abuchyn_alexbundle_items';
    }


}
