<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 25/12/2016
 * Time: 12:48
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Ecommerce\EcommerceBundle\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class ProduitsController extends Controller
{
    public function produitsAction(Request $request, Categories $categorie = null)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        if ($categorie != null)
        {
            $findProduits = $em->getRepository('EcommerceBundle:Produits')->byCategorie($categorie);
        } else
            {
                $findProduits = $em->getRepository('EcommerceBundle:Produits')->findBy(['disponible' => 1]);
            }
        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        $produits = $this->get('knp_paginator')->paginate($findProduits, $request->query->get('page',1)/*page number*/, 12/*limit per page*/);

        return $this->render('EcommerceBundle:Default/produits/layout:produits.html.twig', ['produits' => $produits,
                                                                              'panier' => $panier]);
    }

    public function presentationAction($id, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EcommerceBundle:Produits')->find($id);

        if (!$produit) throw $this->createNotFoundException("La page n'existe pas.");

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;

        return $this->render('EcommerceBundle:Default/produits/layout:presentation.html.twig', ['produit' => $produit,
                                                                                 'panier' => $panier]);
    }
}
