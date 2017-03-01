<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/account")
 */
class UserController extends Controller
{
    public function factureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('EcommerceBundle:Commandes')->byFacture($this->getUser());

        return $this->render('AppBundle:Default/layout:facture.html.twig', ['factures' => $factures]);
    }

    public function facturePDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('EcommerceBundle:Commandes')->findOneBy([
                                                                                'user' => $this->getUser(),
                                                                             'valider' => 1,
                                                                                  'id' => $id
        ]);
        if (!$facture)
        {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue.');
            return $this->redirect($this->generateUrl('factures'));
        }
        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }

    /**
     * @Route("/dashboard", name="user_dashboard")
     * @Method("GET|POST")
     */
    public function dashboardAction()
    {
        return $this->render('user/dashboard.html.twig');

    }


    public function utilisateursAction()
    {
        return $this->render('modulesUsed/utilisateurs.html.twig');
    }
}
