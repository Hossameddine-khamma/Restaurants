<?php

namespace App\Entity;

use App\Repository\CommentairesMenusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentairesMenusRepository::class)
 */
class CommentairesMenus
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
    private $Valeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $Note;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="commentairesMenuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="commentairesMenuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Restaurant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?string
    {
        return $this->Valeur;
    }

    public function setValeur(string $Valeur): self
    {
        $this->Valeur = $Valeur;

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

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(?Users $User): self
    {
        $this->User = $User;

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
