<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Commentaire;
use PiBundle\Entity\Topic;
use PiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Topic controller.
 *
 */
class TopicController extends Controller
{
    /**
     * Lists all topic entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('PiBundle:Topic')->findAll();

        return $this->render('PiBundle:topic:index.html.twig', array(
            'topics' => $topics,
        ));
    }

    /**
     * Creates a new topic entity.
     *
     */
    public function newAction(Request $request)
    {
        $topic = new Topic();
        $form = $this->createForm('PiBundle\Form\TopicType', $topic);
        $form->handleRequest($request);
        //$topic->setIdUser(1);
        $topic->setDate(new \DateTime(date('Y-m-d H:i:s')));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('topic_show', array('id' => $topic->getId()));
        }

        return $this->render('PiBundle:topic:new.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a topic entity.
     *
     */
    public function showAction(Topic $topic)
    {
        $user = new User();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $deleteForm = $this->createDeleteForm($topic);
        $em=$this->getDoctrine()->getManager();
        $commentaires=$em->getRepository('PiBundle:Commentaire')->getbyTopic($topic->getId());
        $reclamation=$em->getRepository('PiBundle:Reclamation')->getbyRecUser($topic->getId(),$user->getId());
        return $this->render('PiBundle:topic:show.html.twig', array(
            'topic' => $topic,
            'delete_form' => $deleteForm->createView(),
            'commentaires'=>$commentaires,
            'user'=>$user,
            'reclamation'=>$reclamation
        ));
    }

    /**
     * Displays a form to edit an existing topic entity.
     *
     */
    public function editAction(Request $request, Topic $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        $editForm = $this->createForm('PiBundle\Form\TopicType', $topic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_edit', array('id' => $topic->getId()));
        }

        return $this->render('PiBundle:topic:edit.html.twig', array(
            'topic' => $topic,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a topic entity.
     *
     */
    public function deleteAction(Request $request, Topic $topic)
    {
        $form = $this->createDeleteForm($topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($topic);
            $em->flush();
        }

        return $this->redirectToRoute('topic_index');
    }

    /**
     * Creates a form to delete a topic entity.
     *
     * @param Topic $topic The topic entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Topic $topic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('topic_delete', array('id' => $topic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function ajouterAction(Request $request)
    {
        $Topic= new Topic();
        $user = new User();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if($request->isMethod("post")) {
            $Topic->setTitre($request->get("titre"));
            $Topic->setContenu($request->get("contenu"));
            $Topic->setType($request->get("type"));
            $Topic->setDate(new \DateTime(date('Y-m-d H:i:s')));
            $Topic->setIdUser($user);
            $EM = $this->getDoctrine()->getManager();
            $EM->persist($Topic);
            $EM->flush();
            return $this->redirectToRoute('topic_index');
        }
        return $this->render('PiBundle:topic:new.html.twig', array(

        ));
    }

    public function filtrage($contenu)
    {
        $bad = array('fuck', 'shit', 'asshole', 'cunt', 'fag', 'fuk', 'fck', 'fcuk', 'assfuck', 'assfucker', 'fucker','motherfucker', 'asscock', 'asshead',
            'asslicker', 'asslick', 'assnigger', 'nigger', 'asssucker', 'bastard', 'bitch', 'bitchtits',
            'bitches', 'bitch', 'brotherfucker', 'bullshit', 'bumblefuck', 'buttfucka', 'fucka', 'buttfucker', 'buttfucka', 'fagbag', 'fagfucker',
            'faggit', 'faggot', 'faggotcock', 'fagtard', 'fatass', 'fuckoff', 'fuckstick', 'fucktard', 'fuckwad', 'fuckwit', 'dick',
            'dickfuck', 'dickhead', 'dickjuice', 'dickmilk', 'doochbag', 'douchebag', 'douche', 'dickweed', 'dyke', 'dumbass', 'dumass',
            'fuckboy', 'fuckbag', 'gayass', 'gayfuck', 'gaylord', 'gaytard', 'nigga', 'niggers', 'niglet', 'paki', 'piss', 'prick', 'pussy',
            'poontang', 'poonany', 'porchmonkey','porch monkey', 'poon', 'queer', 'queerbait', 'queerhole', 'queef', 'renob', 'rimjob', 'ruski',
            'sandnigger', 'sand nigger', 'schlong', 'shitass', 'shitbag', 'shitbagger', 'shitbreath', 'chinc', 'carpetmuncher', 'chink', 'choad', 'clitface',
            'clusterfuck', 'cockass', 'cockbite', 'cockface', 'skank', 'skeet', 'skullfuck', 'slut', 'slutbag', 'splooge', 'twatlips', 'twat',
            'twats', 'twatwaffle', 'vaj', 'vajayjay', 'va-j-j', 'wank', 'wankjob', 'wetback', 'whore', 'whorebag', 'whoreface','merde','pute','putain'
        );
        //replacearray
        $replace =  array('f**k', 's**t', 'a**h**e', 'c**t', 'f*g', 'f*k', 'f*k', 'f**k', 'a**f***k', 'a**f****r', 'f****r', 'mother*****r', 'a**c**k', 'a**h**d',
            'a**l***r', 'a**l**k', 'a**n****r', 'n****r', 'a**s****r', 'b*****d', 'b***h', 'b****t**s',
            'b*****s', 'b***h', 'brotherf****r', 'b***s**t', 'b*****f**k', 'b***f***a', 'f***a', 'b***f****r', 'b***f***a', 'f**b*g', 'f**f****r',
            'f****t', 'f****t', 'f****tc**k', 'f**t**d', 'f**a*s', 'f***o*f', 'f***s***k', 'f***t**d', 'f***w*d', 'f***w*t', 'd**k',
            'd***f**k', 'd***h**d', 'd***j***e', 'd***m**k', 'd****b*g', 'd*****b*g', 'd****e', 'd***w**d', 'd**e', 'd***a*s', 'd**a*s',
            'f***b*y', 'f***b*g', 'g**a*s', 'g**f**k', 'g**l**d', 'g**t**d', 'n***a', 'n*****s', 'n**l*t', 'p**i', 'p**s', 'p***k', 'p****',
            'p***t**g', 'p***a*y', 'p****m****y', 'p***h m****y', 'p**n', 'q***r', 'q***b**t', 'q***h**e', 'q***f', 'r***b', 'r**j*b', 'r***i',
            's***n****r', 's**d n****r', 's*****g', 's***a*s', 's***b*g', 's***b****r', 's***b****h', 'c***c', 'c*****m*****r', 'c***k', 'c***d', 'c***f**e',
            'c******f**k', 'c***a*s', 'c***b**e', 'c***f**e', 's***k', 's***t', 's****f**k', 's**t', 's***b*g', 's*****e','t***l**s', 't**t',
            't***s','t***w****e','v*j','v*j**j*y','v*-*-j','w**k','w*****b','w*****k','w***e','w****bag','w****face','m***e','p***','p****n'
        );
        for ($i=0;$i<count($bad);$i++)
        {
            $contenu=str_replace($bad[$i],$replace[$i],$contenu);
        }
        return $contenu;
    }

    public function addCommentAction(Request $request)
    {
        $Commentaire= new Commentaire();
        $user = new User();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if($request->isMethod("post")) {
            $contenu=$request->get("contenu");
            $Commentaire->setContenu($this->filtrage($contenu));
            $Commentaire->setIdTopic($request->get("topic"));
            $Commentaire->setTitre($request->get("titre"));
            $Commentaire->setIdUser($user);
            $Commentaire->setDate(new \DateTime(date('Y-m-d H:i:s')));
            $EM = $this->getDoctrine()->getManager();
            $EM->persist($Commentaire);
            $EM->flush();
            return $this->redirectToRoute('topic_show',array(
                "id"=>$Commentaire->getIdTopic($request->get("topic"))
            ));
        }
        return $this->render('PiBundle:topic:index.html.twig', array(

        ));
    }
    public function indexAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('PiBundle:Topic')->findAll();

        return $this->render('PiBundle:topic:indexAdmin.html.twig', array(
            'topics' => $topics,
        ));
    }
    public function DeleteTopicAction($id){

        $EM = $this->getDoctrine()->getManager();
        $Topic= $EM->getRepository("PiBundle:Topic")->find("$id");
        $EM->remove($Topic);
        $EM->flush();
        return $this->redirectToRoute('topic_admin_i');
    }

    public function DeleteTopAction($id){

        $EM = $this->getDoctrine()->getManager();
        $Topic= $EM->getRepository("PiBundle:Topic")->find("$id");
        $EM->remove($Topic);
        $EM->flush();
        return $this->redirectToRoute('topic_index');
    }

}
