<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 24/01/18
 * Time: 08:45
 */

namespace App\Twig;

use App\Entity\Tag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('colorize', array($this, 'colorizeFilter'), ['is_safe' => ['html']]),
        ];
    }

    public function colorizeFilter(Tag $tag)
    {
        $style = '';
        if (null !== $tag->getColor()) {
            $style = "background-color:#{$tag->getColor()};";
        }

        return '<span class="tag-color" style="'.$style.'">'.$tag->getName().'</span>';
    }
}