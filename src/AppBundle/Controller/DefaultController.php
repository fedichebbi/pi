<?php

namespace AppBundle\Controller;

use PiBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        if( $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $user = new User();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            if ($user->getRole() == '0')
                return $this->redirect('http://localhost/pi/web/app_dev.php/dash/');
            elseif ($user->getRole() == '1')
                return $this->redirect('http://localhost/pi/web/app_dev.php/topic');
            elseif ($user->getRole() == '2')
                return $this->redirect('http://localhost/pi/web/app_dev.php/article/afficherConseilExpert');
            else
                return $this->redirect('http://localhost/pi/web/app_dev.php/login');
        }
        else return $this->redirect('http://localhost/pi/web/app_dev.php/login');
            /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/
        /*if (is_string($user->getRole()))
        {
            if ($user->getRole() == '0')
                return $this->redirect('http://localhost/pi/web/app_dev.php/dash/');
            elseif ($user->getRole() == '1')
                return $this->redirect('http://localhost/pi/web/app_dev.php/topic');
            elseif ($user->getRole() == '2')
                return $this->redirect('http://localhost/pi/web/app_dev.php/dash/');
            else
                return $this->redirect('http://localhost/pi/web/app_dev.php/login');
        }

        else {
            return $this->redirect('http://localhost/pi/web/app_dev.php/login');
        }*/
        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);*/

    }
}
