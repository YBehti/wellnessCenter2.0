<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="user_type", type="string")
 * @ORM\DiscriminatorMap({"user"="User", "provider"="Provider"})
 */

abstract class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_num;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress_street;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banned = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $register_confirmation = true;

    /**
     * @ORM\Column(type="date")
     */
    protected $registration_date ;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $connection_failed =0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostCode", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post_code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $locality;

    public function __construct(){

        $this->registration_date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdressNum(): ?string
    {
        return $this->adress_num;
    }

    public function setAdressNum(string $adress_num): self
    {
        $this->adress_num = $adress_num;

        return $this;
    }

    public function getAdressStreet(): ?string
    {
        return $this->adress_street;
    }

    public function setAdressStreet(string $adress_street): self
    {
        $this->adress_street = $adress_street;

        return $this;
    }

    public function getBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegisterConfirmation(): ?bool
    {
        return $this->register_confirmation;
    }

    public function setRegisterConfirmation(bool $register_confirmation): self
    {
        $this->register_confirmation = $register_confirmation;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(\DateTimeInterface $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConnectionFailed(): ?int
    {
        return $this->connection_failed;
    }

    public function setConnectionFailed(int $connection_failed): self
    {
        $this->connection_failed = $connection_failed;

        return $this;
    }

    public function getPostCode(): ?PostCode
    {
        return $this->post_code;
    }

    public function setPostCode(?PostCode $post_code): self
    {
        $this->post_code = $post_code;

        return $this;
    }

    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    public function setLocality(?Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }
}
