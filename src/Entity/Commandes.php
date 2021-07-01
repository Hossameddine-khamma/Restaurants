<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandesRepository::class)
 */
class Commandes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Heure;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="Commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Notes::class, inversedBy="commandes", cascade={"persist", "remove"})
     */
    private $Notes;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Restaurants;

    /**
     * @ORM\ManyToMany(targetEntity=Menus::class, inversedBy="commandes")
     */
    private $Menus;

    /**
     * @ORM\OneToOne(targetEntity=Commentaires::class, inversedBy="commandes", cascade={"persist", "remove"})
     */
    private $Commentaires;

    public function __construct()
    {
        $this->Menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?bool
    {
        return $this->Type;
    }

    public function setType(bool $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(\DateTimeInterface $Heure): self
    {
        $this->Heure = $Heure;

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

    public function getNotes(): ?Notes
    {
        return $this->Notes;
    }

    public function setNotes(?Notes $Notes): self
    {
        $this->Notes = $Notes;

        return $this;
    }

    public function getRestaurants(): ?Restaurants
    {
        return $this->Restaurants;
    }

    public function setRestaurants(?Restaurants $Restaurants): self
    {
        $this->Restaurants = $Restaurants;

        return $this;
    }

    /**
     * @return Collection|Menus[]
     */
    public function getMenus(): Collection
    {
        return $this->Menus;
    }

    public function addMenu(Menus $menu): self
    {
        if (!$this->Menus->contains($menu)) {
            $this->Menus[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menus $menu): self
    {
        $this->Menus->removeElement($menu);

        return $this;
    }

    public function getCommentaires(): ?Commentaires
    {
        return $this->Commentaires;
    }

    public function setCommentaires(?Commentaires $Commentaires): self
    {
        $this->Commentaires = $Commentaires;

        return $this;
    }
}
