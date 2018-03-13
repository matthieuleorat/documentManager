<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 30/01/18
 * Time: 07:51
 */

namespace App\Action\Document;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Document;

class UploadAction
{
    /**
     * @param Request $request
     *
     * @Route(
     *     name="media_upload",
     *     path="/media"
     * )
     * @Method("POST")
     */
    public function __invoke(Request $request)
    {
        die(dump($request));
    }
}