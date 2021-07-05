<?php

namespace App\Entity;

use App\Repository\RestaurantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantsRepository::class)
 */
class Restaurants
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
    private $Nom;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="Restaurant")
     */
    private $Salarie;

    /**
     * @ORM\OneToMany(targetEntity=Commandes::class, mappedBy="Restaurants", orphanRemoval=true)
     */
    private $commandes;

    /**
     * @ORM\ManyToMany(targetEntity=Menus::class, inversedBy="restaurants")
     */
    private $Menus;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="Restaurant", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=CommentairesMenus::class, mappedBy="Restaurant", orphanRemoval=true)
     */
    private $commentairesMenuses;


    public function __construct()
    {
        $this->Salarie = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->Menus = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->commentairesMenuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getSalarie(): Collection
    {
        return $this->Salarie;
    }

    public function addSalarie(Users $salarie): self
    {
        if (!$this->Salarie->contains($salarie)) {
            $this->Salarie[] = $salarie;
            $salarie->setRestaurant($this);
        }

        return $this;
    }

    public function removeSalarie(Users $salarie): self
    {
        if ($this->Salarie->removeElement($salarie)) {
            // set the owning side to null (unless already changed)
            if ($salarie->getRestaurant() === $this) {
                $salarie->setRestaurant(null);
            }
        }

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
            $commande->setRestaurants($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getRestaurants() === $this) {
                $commande->setRestaurants(null);
            }
        }

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

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setRestaurant($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getRestaurant() === $this) {
                $commentaire->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentairesMenus[]
     */
    public function getCommentairesMenuses(): Collection
    {
        return $this->commentairesMenuses;
    }

    public function addCommentairesMenus(CommentairesMenus $commentairesMenus): self
    {
        if (!$this->commentairesMenuses->contains($commentairesMenus)) {
            $this->commentairesMenuses[] = $commentairesMenus;
            $commentairesMenus->setRestaurant($this);
        }

        return $this;
    }

    public function removeCommentairesMenus(CommentairesMenus $commentairesMenus): self
    {
        if ($this->commentairesMenuses->removeElement($commentairesMenus)) {
            // set the owning side to null (unless already changed)
            if ($commentairesMenus->getRestaurant() === $this) {
                $commentairesMenus->setRestaurant(null);
            }
        }

        return $this;
    }

}
