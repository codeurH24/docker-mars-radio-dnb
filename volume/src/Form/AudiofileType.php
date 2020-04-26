<?php

namespace App\Form;

use App\Entity\Audiofile;
use App\Repository\AudioFileRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AudiofileType extends AbstractType
{

    private $appKernel;
    private $audiofileRepo;

    public function __construct(KernelInterface $appKernel, AudioFileRepository $audiofileRepo)
    {
        $this->appKernel = $appKernel;
        $this->audiofileRepo = $audiofileRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $root = $this->appKernel->getProjectDir();
        $listFileUploaded = scandir($root."/upload/mix");
        
        $choiceMP3File = [];
        foreach ($listFileUploaded as $key => $file) {

            if(in_array($file, ['.', '..'])) continue;

            $path_parts = pathinfo($file);
            $ext = $path_parts['extension'];
            if($ext == 'mp3') {
                $choiceMP3File[$file] = $file;
            }
        }

        $builder
            ->add('pseudo')
            ->add('dj')
            ->add('group')
            ->add('title');
            // dd($options['data']);
            if (isset($options['data']) && $options['data']->getFilename() !== null) {
                // $builder->add('filename', TextType::class, [
                //     'attr' => ['disabled' => 'true'],
                // ]);
            }else {
                $builder->add('filename', ChoiceType::class, [
                    'choices' => $choiceMP3File,
                ]);
            }
            
            // ->add('picture')
            $builder->add('picture', FileType::class, [
                'label' => 'Image mix',
                'required' => false,
                'data_class' => null,
                'empty_data' => $options['data']->getPicture(),
            ])
            ->add('description')
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Jungle' => 'Jungle',
                    'Techstep' => 'Techstep',
                    'Neurofunk' => 'Neurofunk', 
                    'Ragga/Jungle' => 'Ragga/Jungle',
                    'Dubstep' => 'Dubstep',
                    'Dub' => 'Dub',
                    'Drumstep' => 'Drumstep',
                    'Trip hop' => 'Trip hop',
                    'Jungle' => 'Jungle',
                    'Trap' => 'Trap',
                    'Hardstep' => 'Hardstep',
                    'Old School' => 'Old School',
                    'Jump Up' => 'Jump Up',
                    'Liquid' => 'Liquid',
                    'Darkstep' => 'Darkstep',

                ],
                'multiple' => true,
                'expanded' => true,
                
            ])
            
            // // ->add('filesize')
            ->add('publish', CheckboxType::class, [
                'label'    => 'Publier ?',
                'required' => true,
                'attr' => ['checked' => 'true'],
            ])
            // ->add('oldFilename')
            // ->add('fileCreatedAt')
            // ->add('old_picture_name')
        ;


        $builder->get('genre')
        ->addModelTransformer(new CallbackTransformer(
            
            function ($tagsAsArray) {
                // transform the array to a string
                if ($tagsAsArray === null) return [];
                return explode(' - ', $tagsAsArray);
            },
            function ($tagsAsString) {
                // transform the string back to an array
                // dd(implode(' - ', $tagsAsString));
                return implode(' - ', $tagsAsString);
            },
        ))
    ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Audiofile::class,
        ]);
    }
}
