<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 12/01/2017
 * Time: 13:51
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Media;

class MediaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/resized/DSCN3797_110x146.JPG');
        $media1->setAlt('Oeuf au plat');
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/resized/crocro_pick_4f3e19dbcb403_150x110.jpg');
        $media2->setAlt('Crocos');
        $manager->persist($media2);

        $media3 = new Media();
        $media3->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/DSCN3781.JPG');
        $media3->setAlt('Flamboti Caramel');
        $manager->persist($media3);

        $media4 = new Media();
        $media4->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/Rouleaux_r__glis_56151cb1cb11a.jpg');
        $media4->setAlt('Rouleaux Réglisse');
        $manager->persist($media4);

        $media5 = new Media();
        $media5->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/fraise_tagada_pi_4bc2d2ef209f7.jpg');
        $media5->setAlt('Fraise Tagada Pink');
        $manager->persist($media5);

        $media6 = new Media();
        $media6->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/DSCN3748.JPG');
        $media6->setAlt('Dragibus');
        $manager->persist($media6);

        $media7 = new Media();
        $media7->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/DSCN4202%20[640x480].JPG');
        $media7->setAlt('Schtroumpfs');
        $manager->persist($media7);

        $media8 = new Media();
        $media8->setPath('http://www.au-bon-bec.com/components/com_virtuemart/shop_image/product/Haribo_Miami_Pik_56151afe62aed.jpg');
        $media8->setAlt('Miami Pik');
        $manager->persist($media8);

        $media9 = new Media();
        $media9->setPath('http://blog.ac-versailles.fr/moulinblog/public/Decembre_2012/bonbon.jpg');
        $media9->setAlt('Bonbons');
        $manager->persist($media9);

        $media10 = new Media();
        $media10->setPath('http://www.confiseriedesgaves.fr/images/confiserie.jpg');
        $media10->setAlt('Confiseries');
        $manager->persist($media10);

        $manager->flush();

        $this->addReference('media1', $media1);
        $this->addReference('media2', $media2);
        $this->addReference('media3', $media3);
        $this->addReference('media4', $media4);
        $this->addReference('media5', $media5);
        $this->addReference('media6', $media6);
        $this->addReference('media7', $media7);
        $this->addReference('media8', $media8);
        $this->addReference('media9', $media9);
        $this->addReference('media10', $media10);
    }
    public function getOrder()
    {
        return 1;
    }
}