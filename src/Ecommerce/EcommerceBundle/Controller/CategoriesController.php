<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 13/01/2017
 * Time: 06:58
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();

        return $this->render('EcommerceBundle:Default/categories/modulesUsed:menu.html.twig', ['categories' => $categories]);
    }
}