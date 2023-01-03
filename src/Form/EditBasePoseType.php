<?php

namespace App\Form;

use App\Entity\BasePose;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditBasePoseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('base_pose_name')
            ->add('base_pose_description',TextareaType::class, [
                'attr' => array('cols' => '50', 'rows' => '5')])
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