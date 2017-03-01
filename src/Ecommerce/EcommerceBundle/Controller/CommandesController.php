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

class CommandesController extends Controller
{
    public function factureAction($request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = [];
        $totalHT = 0;
        $totalTVA = 0;

        $facturation = $em->getRepository('EcommerceBundle:UsersAdresses')->find($adresse['facturation']);
        $livraison= $em->getRepository('EcommerceBundle:UsersAdresses')->find($adresse['livraison']);
        $produits= $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));

        foreach($produits as $produit)
        {
            $prixHT =($produit->getPrix()* $panier[$produit->getId()]);
            $prixTTC =($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate()) ;
            $totalHT += $prixHT;

            if (!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
            {
                $commande['tva']['%'.$produit->getTva()->getValeur()] = round($prixTTC - $prixHT,2);
            } else
            {
                $commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);
            }
            $totalTVA += round($prixTTC - $prixHT, 2);
            $commande['produit'][$produit->getId()] =[
                                                     'reference' => $produit->getNom(),
                                                      'quantite' => $panier[$produit->getId()],
                                                        'prixHT' => round($produit->getPrix(),2),
                                                       'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(),2)

            ];
        }
            $commande['livraison'] = [
                                      'prenom' => $livraison->getPrenom(),
                                         'nom' => $livraison->getNom(),
                                    'telephone'=> $livraison->getTelephone(),
                                      'adresse'=> $livraison->getAdresse(),
                                           'cp'=> $livraison->getCp(),
                                        'ville'=> $livraison->getVille(),
                                         'pays'=> $livraison->getPays(),
                                   'complement'=> $livraison->getComplement()
            ];

            $commande['facturation'] = [
                                        'prenom' => $facturation->getPrenom(),
                                           'nom' => $facturation->getNom(),
                                     'telephone' => $facturation->getTelephone(),
                                       'adresse' => $facturation->getAdresse(),
                                            'cp' => $facturation->getCp(),
                                         'ville' => $facturation->getVille(),
                                          'pays' => $facturation->getPays(),
                                    'complement' => $facturation->getComplement()
            ];

            $commande['prixHT'] = round($totalHT,2);
            $commande['prixTTC'] = round($totalHT + $totalTVA,2);

            return $commande;



    }

     public function prepareCommandeAction(Request $request)
     {

         $session = $request->getSession();
         $em = $this->getDoctrine()->getManager();

         if (!$session->has('commande')) {
             $commande = new Commandes();
         } else {
             $commande = $em->getRepository('EcommerceBundle:Commandes')->find($session->get('commande'));
         }
         $commande->setDate(new \DateTime());
         $commande->setUser($this->container->get('security.token_storage')->getToken()->getUser());
         $commande->setValider(0);
         $commande->setReference(0);
         $commande->setCommande($this->facture($request));

         if (!$session->has('commande')){
             $em->persist($commande);
             $session->set('commande', $commande);
         }
         $em->flush();

         return new Response($commande->getId());
     }

     /*
      * Cette method remplace l'api Banque " il faudra penser a generer un token"
      */
     public function validationCommandeAction($id, Request $request)
     {
         $em =$this->getDoctrine()->getManager();
         $commande = $em->getRepository('EcommerceBundle:Commandes')->find($id);


         $commande->setValider(1);
         $commande->setReference($this->container->get('setNewReference')->reference()); //service
         $em->flush();

         $session = $request->getSession();
         $session->remove('adresse');
         $session->remove('panier');
         $session->remove('commande');

         \Stripe\Stripe::setApiKey("sk_test_72A4J5pZz30gqeKeHY79TuzV");

         // Get the credit card details submitted by the form
         $token = $_POST['stripeToken'];

         // Create a charge: this will charge the user's card
         try {
             $charge = \Stripe\Charge::create(array(
                 "amount" => 1000, // Amount in cents
                 "currency" => "eur",
                 "source" => $token,
                 "description" => "Paiement Stripe - Bonbons"
             ));
             $this->get('session')->getFlashBag()->add('success', 'Votre commande est validé avec succés');
             return $this->redirect($this->generateUrl('factures'));
         } catch (\Stripe\Error\Card $e) {

             $this->addFlash("error", "Snif ça marche pas :(");
             return $this->redirectToRoute('panier');
             // The card has been declined
         }
         $this->get('session')->getFlashBag()->add('success', 'Votre commande est validé avec succés');
         return $this->redirect($this->generateUrl('factures'));
     }
}
  
