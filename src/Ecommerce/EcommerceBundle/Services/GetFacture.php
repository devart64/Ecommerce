<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 07/02/2017
 * Time: 07:02
 */

namespace Ecommerce\EcommerceBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;


class GetFacture
{

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function facture($facture)
    {
        //on stocke la vue à convertir en PDF, en n'oubliant pas les paramètres twig si la vue comporte des données dynamiques

        $html = $this->container->get('templating')->render('AppBundle:Default/layout:facturePDF.html.twig', ['facture' => $facture]);

        //on instancie la classe Html2Pdf_Html2Pdf en lui passant en paramètre
        //le sens de la page "portrait" => p ou "paysage" => l
        //le format A4,A5...
        //la langue du document fr,en,it...
        $html2pdf = new \Html2Pdf_Html2Pdf('P', 'A4', 'fr');
        $html2pdf->pdf->SetAuthor('Devart64');
        $html2pdf->pdf->SetTitle('Facture' . $facture->getReference());
        $html2pdf->pdf->SetSubject('Facture Devart64');
        $html2pdf->pdf->SetKeywords('Facture,Devart64');
        //SetDisplayMode définit la manière dont le document PDF va être affiché par l’utilisateur
        //fullpage : affiche la page entière sur l'écran
        //fullwidth : utilise la largeur maximum de la fenêtre
        //real : utilise la taille réelle
        $html2pdf->pdf->SetDisplayMode('real');

        //writeHTML va tout simplement prendre la vue stocker dans la variable $html pour la convertir en format PDF
        $html2pdf->writeHTML($html);

        //Output envoit le document PDF au navigateur internet avec un nom spécifique qui aura un rapport avec le contenu à convertir (exemple : Facture, Règlement…)
       // $html2pdf->Output('Facture.pdf');

        return $html2pdf;

    }
}