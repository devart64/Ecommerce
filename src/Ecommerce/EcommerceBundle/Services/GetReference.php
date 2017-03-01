<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 07/02/2017
 * Time: 07:02
 */

namespace Ecommerce\EcommerceBundle\Services;


class GetReference
{

    public function __construct($securityTokenStorage, $entityManager)
    {
        $this->securityContext = $securityTokenStorage;
        $this->em = $entityManager;

    }

    public function reference()
    {
        $reference = $this->em->getRepository('EcommerceBundle:Commandes')->findOneBy(['valider' => 1],['id' => 'DESC'],1,1);

        if (!$reference)
        {
            return 1;
        } else
        {
            return $reference->getReference() +1;
        }
    }
}
