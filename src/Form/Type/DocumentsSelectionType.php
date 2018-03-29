<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 22/03/18
 * Time: 08:57
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DocumentsSelectionType extends AbstractType
{
    const NAME = 'app_documents_selection';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recipients', TextType::class)
        ;
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return CollectionType::class;
    }
}