<?php

namespace MyApp\UserBundle\Controller;

use PiBundle\Entity\Question;
use PiBundle\Entity\Reponce;
use PiBundle\Entity\Video;
use PiBundle\Form\ReponceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppUserBundle:Default:index.html.twig');
    }

    public function playAction()
    {
        $videoId = 1;
        $em = $this->getDoctrine()->getManager();

        $video = $em->getRepository(Video::class)->find($videoId);
        $questions = $em->getRepository(Question::class)->findBy(['idVideo' => $videoId]);
        $answerResponses = [];

        foreach ($questions as $question) {
            $responses = $em->getRepository(Reponce::class)->findBy(['idQuestion' => $question->getId()]);
            $answerResponses[$question->getId()] = $responses;
        }

        return $this->render('MyAppUserBundle:User:loisir.html.twig'
            , array('video' => $video, 'questions' => $questions, 'answerResponse' => $answerResponses));
    }

    public function resultAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $score = 0;
        $data = $request->request->all();
        foreach ($data as $id => $value) {
            $question = $em->getRepository(Question::class)->findOneBy(['id' => $id]);
            $responses = $em->getRepository(Reponce::class)->findBy(['idQuestion' => $id]);
            foreach ($responses as $response) {
                if (($response->getId() == $value) && (intval($response->getCorrection()) == 1)) {
                    $score = $question->getScore() + $score;
                }
            }
        }
        die("score: $score");
    }

}