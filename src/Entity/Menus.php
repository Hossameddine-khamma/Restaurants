<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenusRepository::class)
 */
class Menus
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
    private $Entree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Plat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Dessert;

    /**
     * @ORM\ManyToMany(targetEntity=Commandes::class, mappedBy="Menus")
     */
    private $commandes;

    /**
     * @ORM\ManyToMany(targetEntity=Restaurants::class, mappedBy="Menus")
     */
    private $restaurants;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->restaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntree(): ?string
    {
        return $this->Entree;
    }

    public function setEntree(string $Entree): self
    {
        $this->Entree = $Entree;

        return $this;
    }

    public function getPlat(): ?string
    {
        return $this->Plat;
    }

    public function setPlat(string $Plat): self
    {
        $this->Plat = $Plat;

        return $this;
    }

    public function getDessert(): ?string
    {
        return $this->Dessert;
    }

    public function setDessert(string $Dessert): self
    {
        $this->Dessert = $Dessert;

        return $this;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addMenu($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection|Restaurants[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurants $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->addMenu($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurants $restaurant): self
    {
        if ($this->restaurants->removeElement($restaurant)) {
            $restaurant->removeMenu($this);
        }

        return $this;
    }
}
