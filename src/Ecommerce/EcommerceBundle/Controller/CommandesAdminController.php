<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 06/02/2017
 * Time: 12:45
 */

namespace Ecommerce\EcommerceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Entity\Produits;
use AppBundle\Entity\User;

class CommandesAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('EcommerceBundle:Commandes')->findAll();


        return $this->render('administration/commandes/index.html.twig', ['commandes' => $commande]);
    }
    public function showAction($id)
    {

            $em = $this->getDoctrine()->getManager();
            $facture = $em->getRepository('EcommerceBundle:Commandes')->find($id);
            if (!$facture) {
                $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue.');

                return $this->redirect($this->generateUrl('commandes_index'));
            }
            $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }

}