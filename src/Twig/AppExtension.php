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
            $style = "background-color:#{$tag->getColor()};display: inline-block; width: 10px; height:10px; margin-right: 5px;";
        }

        return '<span class="tag-color" ><span style="'.$style.'"></span>'.$tag->getName().'</span>';
    }
}
