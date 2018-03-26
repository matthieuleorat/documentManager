<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 23/03/18
 * Time: 15:08
 */

namespace App\Form\Type;


use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class SearchTagsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'expanded' => true,
            ])
        ;

        $formModifier = function (FormInterface $form, $tags) {
            $form->add('tags', EntityType::class, [
                'class' => Tag::class,
                'query_builder' => function (TagRepository $repository) use ($tags) {
                    return $repository->search($tags);
                },
                'data' => $tags,
                'multiple' => true,
                'expanded' => true,
            ]);
        };

        $builder->get('tags')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $tags = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $tags);
            }
        );
    }
}
