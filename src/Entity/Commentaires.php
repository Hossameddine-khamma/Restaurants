<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentairesRepository::class)
 */
class Commentaires
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Valeurs;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="Commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $Note;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Restaurant;

    public function __construct()
    {
        $this->Restaurant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurs(): ?string
    {
        return $this->Valeurs;
    }

    public function setValeurs(string $Valeurs): self
    {
        $this->Valeurs = $Valeurs;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }


    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(int $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getRestaurant(): ?Restaurants
    {
        return $this->Restaurant;
    }

    public function setRestaurant(?Restaurants $Restaurant): self
    {
        $this->Restaurant = $Restaurant;

        return $this;
    }
}
