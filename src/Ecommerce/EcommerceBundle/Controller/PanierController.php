<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 25/12/2016
 * Time: 12:51
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Ecommerce\EcommerceBundle\Entity\UsersAdresses;
use Ecommerce\EcommerceBundle\Form\UsersAdressesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    public function menuAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('EcommerceBundle:Default/panier/modulesUsed:panier.html.twig', ['articles' => $articles]);
    }

    public function ajouterAction($id, Request $request)
    {
         $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier',[]);
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)){
            if ($request->query->get('qte') !== null) $panier[$id] = $request->query->get('qte');
            $this->get('session')->getFlashBag()->add('success', 'Quantité modifiée avec succès.');

        } else {
            if ($request->query->get('qte') !== null)
                $panier[$id] = $request->query->get('qte');
         else
        $panier[$id] = 1;
            $this->get('session')->getFlashBag()->add('success', 'Article ajouté avec succès.');

        }
        $session->set('panier', $panier);

        return $this->redirect($this->generateUrl('panier'));
    }

    public function supprimerAction($id, Request $request)
    {
         
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier', $panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès.');
        }

        return $this->redirect($this->generateUrl('panier'));
    }

    public function panierAction(Request $request)
    {
        $session = $request->getSession();
       
        if (!$session->has('panier')) $session->set('panier', []);
        
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        return $this->render('EcommerceBundle:Default/panier/layout:panier.html.twig', ['produits' => $produits,
                                                                          'panier' => $session->get('panier')]);
    }

    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EcommerceBundle:UsersAdresses')->find($id);

        if ($this->container->get('security.token_storage')->getToken()->getUser() != $entity->getUser() || !$entity)
        {
            return $this->redirect($this->generateUrl('livraison'));
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('livraison'));
    }

    public function livraisonAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $entity = new UsersAdresses();
        $form = $this->createForm(UsersAdressesType::class, $entity);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $entity->setUser($user);
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('livraison'));
            }
        }
        return $this->render('EcommerceBundle:Default/panier/layout:livraison.html.twig', ['user' => $user,
                                                                            'form' => $form->createView()]);
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();
        if(!$session->has('adresse')) $session->set('adresse',[]);
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null && $request->request->get('facturation')!= null)
        {
            $adresse['livraison'] = $request->request->get('livraison');
            $adresse['facturation'] = $request->request->get('facturation');
        }else {
            return $this->redirect($this->generateUrl('validation'));
        }
        $session->set('adresse', $adresse);
        return $this->redirect($this->generateUrl('validation'));
    }

    public function validationAction(Request $request)
    {
        if ($request->isMethod('POST'))
          $this->setLivraisonOnSession($request);

        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('EcommerceBundle:Commandes:prepareCommande');
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($prepareCommande->getContent());


        return $this->render('EcommerceBundle:Default/panier/layout:validation.html.twig', ['commande'=> $commande]);
    }

}
