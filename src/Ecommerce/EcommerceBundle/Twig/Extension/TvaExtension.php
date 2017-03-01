<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 31/01/2017
 * Time: 11:19
 */

namespace Ecommerce\EcommerceBundle\Twig\Extension;


class TvaExtension extends \Twig_Extension
{
    public function getFilters() //method obligatoire
    {
        return [new \Twig_SimpleFilter('tva', [$this,'calculTva'])];// permet d'utiliser dans vue sous forme de filtre twig et quel method y est associée
    }

    public function calculTva($prixHT, $tva)
    {
        return round ($prixHT / $tva,2);
    }

    public function getName() //method obligatoire
    {
        return 'tva_extension';
    }
}
