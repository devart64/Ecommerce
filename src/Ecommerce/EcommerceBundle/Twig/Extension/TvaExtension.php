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
    public function getFilters()
    {
        return [new \Twig_SimpleFilter('tva', [$this,'calculTva'])];
    }

    function calculTva($prixHT, $tva)
    {
        return round ($prixHT / $tva,2);
    }

    public function getName()
    {
        return 'tva_extension';
    }

}