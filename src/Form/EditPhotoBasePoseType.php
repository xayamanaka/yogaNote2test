<?php

namespace App\Form;

use App\Entity\BasePose;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditPhotoBasePoseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('base_pose_name')
            ->add('base_pose_image',FileType::class,[ 'mapped' => false])
            ->add('base_pose_category', ChoiceType::class, [
                'choices'  => [
                    'Basic' => 'basic',
                    'Ashtanga' => 'ashtanga',
                    'Other' => 'other',
                ],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BasePose::class,
        ]);
    }
}