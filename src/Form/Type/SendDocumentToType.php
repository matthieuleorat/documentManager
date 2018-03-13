<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 13/03/18
 * Time: 15:24
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SendDocumentToType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipients', TextType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class)
            ->add('submit', SubmitType::class)
        ;
    }
}