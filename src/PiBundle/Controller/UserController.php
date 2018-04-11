<?php
/**
 * Created by PhpStorm.
 * User: Fedi
 * Date: 11/04/2018
 * Time: 00:19
 */

namespace PiBundle\Controller;


use PiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function registrationAction(Request $request)
    {
        $user=new User();
        if($request->isMethod("post")) {
            $user->setUsername($request->get("username"));
            $user->setPassword($request->get("password"));
            $user->setEmail($request->get("email"));
            $user->setRole($request->get("role"));
            $user->setEnabled(1);
            $EM = $this->getDoctrine()->getManager();
            $EM->persist($user);
            $EM->flush();
            return $this->redirect("http://localhost/pi/web/app_dev.php/login");
        }
        return $this->render('PiBundle:user:registration.html.twig', array(

        ));
    }
}