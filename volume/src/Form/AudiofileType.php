<?php

namespace App\Form;

use App\Entity\Audiofile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudiofileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('dj')
            ->add('group')
            ->add('title')
            ->add('filename')
            ->add('picture')
            ->add('description')
            ->add('genre')
            ->add('filesize')
            ->add('publish')
            ->add('oldFilename')
            ->add('fileCreatedAt')
            ->add('old_picture_name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Audiofile::class,
        ]);
    }
}
