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
use Ecommerce\EcommerceBundle\Entity\Produits;

class ProduitsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $produit1 = new Produits();
        $produit1->setCategorie($this->getReference('categorie1'));
        $produit1->setDescription("L'oeuf au plat, pour les grands et les petits! Vendu par 100grs.");
        $produit1->setDisponible(1);
        $produit1->setImage($this->getReference('media1'));
        $produit1->setNom('Oeuf au plat ');
        $produit1->setPrix('1.20');
        $produit1->setTva($this->getReference('tva2'));
        $manager->persist($produit1);

        $produit2 = new Produits();
        $produit2->setCategorie($this->getReference('categorie1'));
        $produit2->setDescription("Le crocos pour les mordus d'Haribo! Vendu par 100grs.");
        $produit2->setDisponible(1);
        $produit2->setImage($this->getReference('media2'));
        $produit2->setNom('Crocos ');
        $produit2->setPrix('1.19');
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);

        $produit3 = new Produits();
        $produit3->setCategorie($this->getReference('categorie1'));
        $produit3->setDescription("Le flam, un dessert à toute heure! Vendu par 100grs.");
        $produit3->setDisponible(1);
        $produit3->setImage($this->getReference('media3'));
        $produit3->setNom('Flamboti Caramel');
        $produit3->setPrix('1.22');
        $produit3->setTva($this->getReference('tva2'));
        $manager->persist($produit3);

        $produit4 = new Produits();
        $produit4->setCategorie($this->getReference('categorie1'));
        $produit4->setDescription("Le rouleaux de réglisse, à derouler sens faim! Vendu par pochon de 450grs.");
        $produit4->setDisponible(1);
        $produit4->setImage($this->getReference('media4'));
        $produit4->setNom('Rouleaux de réglisse');
        $produit4->setPrix('4.16');
        $produit4->setTva($this->getReference('tva2'));
        $manager->persist($produit4);

        $produit5 = new Produits();
        $produit5->setCategorie($this->getReference('categorie2'));
        $produit5->setDescription("La fraise qui voie la vie en rose! Vendu par 100grs.");
        $produit5->setDisponible(1);
        $produit5->setImage($this->getReference('media5'));
        $produit5->setNom('Fraise Tagada Pink');
        $produit5->setPrix('1.20');
        $produit5->setTva($this->getReference('tva2'));
        $manager->persist($produit5);

        $produit6 = new Produits();
        $produit6->setCategorie($this->getReference('categorie2'));
        $produit6->setDescription("Dragibus les boules sucrées et colorées! Vendu par pochon de 100grs");
        $produit6->setDisponible(1);
        $produit6->setImage($this->getReference('media6'));
        $produit6->setNom('Dragibus');
        $produit6->setPrix('1.05');
        $produit6->setTva($this->getReference('tva2'));
        $manager->persist($produit6);

        $produit7 = new Produits();
        $produit7->setCategorie($this->getReference('categorie2'));
        $produit7->setDescription("Le Schtroumf est schtroumfment bon! Vendu par pochon de 100grs");
        $produit7->setDisponible(1);
        $produit7->setImage($this->getReference('media7'));
        $produit7->setNom('Rouleaux de réglisse');
        $produit7->setPrix('1.20');
        $produit7->setTva($this->getReference('tva2'));
        $manager->persist($produit7);

        $produit8 = new Produits();
        $produit8->setCategorie($this->getReference('categorie2'));
        $produit8->setDescription("Le bonbons qui à des airs d'Amérique! Vendu par pochon de 100grs");
        $produit8->setDisponible(1);
        $produit8->setImage($this->getReference('media8'));
        $produit8->setNom('Miami Pik');
        $produit8->setPrix('1.30');
        $produit8->setTva($this->getReference('tva2'));
        $manager->persist($produit8);

        $manager->flush();



    }

    public function getOrder()
    {
        return 4;
    }
}