<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 12/01/2017
 * Time: 16:39
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\UsersAdresses;

class UsersAdressesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adresse1 = new UsersAdresses();
        $adresse1->setUser($this->getReference('user1'));
        $adresse1->setNom('Dupré');
        $adresse1->setPrenom('Stephen');
        $adresse1->setTelephone('0761283965');
        $adresse1->setAdresse('3 allée Larre Goiti Bidea');
        $adresse1->setCp('64500');
        $adresse1->setPays('France');
        $adresse1->setVille('Ascain');
        $adresse1->setComplement('Appartement n°2');
        $manager->persist($adresse1);

        $manager->flush();

    }

    public function getOrder()
    {
        return 6;
    }
}