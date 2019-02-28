<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
 * @UniqueEntity("email_pro")

 * @UniqueEntity("VAT_number")
 */
class Provider extends User
{


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @Gedmo\Slug(fields={"name"})
     *  @ORM\Column(type="string", length=255, nullable=true)
     */

    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email_pro;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[A-Za-z]+$/")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{8,15}$/")
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $VAT_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Service", inversedBy="providers")
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="provider")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Internship", mappedBy="provider")

     */
    private $internship;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="provider")
     */
    private $comment;









    public function __construct()
    {
        $this->services = new ArrayCollection();

        parent::__construct();
        $this->image = new ArrayCollection();
        $this->internship = new ArrayCollection();
        $this->comment = new ArrayCollection();




    }

    public function getId(): ?int
    {
        return $this->id;
    }





    public function getEmailPro(): ?string
    {
        return $this->email_pro;
    }

    public function setEmailPro(?string $email_pro): self
    {
        $this->email_pro = $email_pro;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getVATNumber(): ?string
    {
        return $this->VAT_number;
    }

    public function setVATNumber(string $VAT_number): self
    {
        $this->VAT_number = $VAT_number;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProvider($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProvider() === $this) {
                $image->setProvider(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Internship[]
     */
    public function getInternship(): Collection
    {
        return $this->internship;
    }

    public function addInternship(Internship $internship): self
    {
        if (!$this->internship->contains($internship)) {
            $this->internship[] = $internship;
            $internship->setProvider($this);
        }

        return $this;
    }

    public function removeInternship(Internship $internship): self
    {
        if ($this->internship->contains($internship)) {
            $this->internship->removeElement($internship);
            // set the owning side to null (unless already changed)
            if ($internship->getProvider() === $this) {
                $internship->setProvider(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setProvider($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->contains($comment)) {
            $this->comment->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProvider() === $this) {
                $comment->setProvider(null);
            }
        }

        return $this;
    }












}
