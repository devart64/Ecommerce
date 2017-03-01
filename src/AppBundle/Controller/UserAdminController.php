<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/account")
 */
class UserAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('administration/clients/index.html.twig', ['users' => $users]);
    }

    public function userAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $route  = $request->get('_route');
       if  ($route == 'adressesClients')
        {
            return $this->render('administration/clients/adresses.html.twig', ['user' => $user]);

        } else if ($route == 'facturesClients')
       {
           return $this->render('administration/clients/factures.html.twig', ['user' => $user]);
       } else
       {
           throw $this->createNotFoundException('La vue n\'existe pas.');
       }
    }
}
