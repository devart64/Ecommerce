<?php
/**
 * Created by PhpStorm.
 * User: monark
 * Date: 12/01/2017
 * Time: 16:39
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * (@inheritdoc)
     */
    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    /**
     * (@inheritdoc)
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setName('stephen');
        $user1->setEmail('stephendupre64@gmail.com');
        $user1->setRole('ADMIN');
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user1);
        $user1->setPassword($encoder->encodePassword('valerie', $user1->getSalt()));

        $manager->persist($user1);



        $manager->flush();

        $this->addReference('user1', $user1);
    }

    public function getOrder()
    {
        return 5;
    }
}

