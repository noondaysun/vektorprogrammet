<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class StaticContentController extends Controller
{
    /**
     * Updates the static text content in database.
     *
     * @return JsonResponse
     */
    public function updateAction()
    {
        $req = $this->get('request');
        $htmlId = $req->get('editorID');
        $newContent = $req->get('editabledata');
        $em = $this->getDoctrine()->getEntityManager();
        $content = $em->getRepository('AppBundle:StaticContent')
            ->findOneByHtmlId($htmlId);
        $content->setHtml($newContent);
        $em->persist($content);
        $em->flush();

        return new JsonResponse(array('status' => 'Database updated static element '.$htmlId.' New content: '.$newContent));
    }
}
