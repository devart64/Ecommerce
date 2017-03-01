<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This email address is already in use")
 */
class User 
{
    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
    * @ORM\OneToMany(targetEntity="Ecommerce\EcommerceBundle\Entity\Commandes", mappedBy="user", cascade={"remove"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $commandes;

    /**
    * @ORM\OneToMany(targetEntity="Ecommerce\EcommerceBundle\Entity\UsersAdresses", mappedBy="user", cascade={"remove"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $adresses;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $role;

    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    public function eraseCredentials()
    {
        return null;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = null)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [$this->getRole()];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
        return null;
    }


    /**
     * Add commande
     *
     * @param \Ecommerce\EcommerceBundle\Entity\Commandes $commande
     *
     * @return User
     */
    public function addCommande(\Ecommerce\EcommerceBundle\Entity\Commandes $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \Ecommerce\EcommerceBundle\Entity\Commandes $commande
     */
    public function removeCommande(\Ecommerce\EcommerceBundle\Entity\Commandes $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adress
     *
     * @param \Ecommerce\EcommerceBundle\Entity\UsersAdresses $adress
     *
     * @return User
     */
    public function addAdress(\Ecommerce\EcommerceBundle\Entity\UsersAdresses $adress)
    {
        $this->adresses[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \Ecommerce\EcommerceBundle\Entity\UsersAdresses $adress
     */
    public function removeAdress(\Ecommerce\EcommerceBundle\Entity\UsersAdresses $adress)
    {
        $this->adresses->removeElement($adress);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}
