<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="Ecommerce\EcommerceBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    public $path;

    public $file;


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
  public function preUpload()
  {
      $this->tempFile = $this->getAbsolutePath();
      $this->oldFile = $this->getPath();

      if(null !== $this->file)
      {
          $this->path = sha1(uniqid(mt_rand(),true)).'.'.$this->file->guessExtension();
      }
  }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
  public function upload()
  {
      if (null !== $this->file)
      {
          $this->file->move($this->getUploadRootDir(),$this->path);
          unset($this->file);

          if ($this->oldFile != null) unlink($this->tempFile);
      }
  }

    /**
     * @ORM\PreRemove()
     */
    public function preRemove()
    {
        $this->tempFile = $this->getAbsolutePath();

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFile)) unlink($this->tempFile);
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
