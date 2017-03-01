<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 31/01/2017
 * Time: 11:19
 */

namespace Ecommerce\EcommerceBundle\Twig\Extension;


class MontantTvaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [new \Twig_SimpleFilter('montantTva', [$this,'montantTva'])];
    }

    public function montantTva($prixHT, $tva)
    {
        return round ((($prixHT / $tva) - $prixHT),2);
    }

    public function getName()
    {
        return 'montant_tva_extension';
    }

}