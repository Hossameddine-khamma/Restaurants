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

    /**
     * @ORM\OneToMany(targetEntity=CommentairesMenus::class, mappedBy="Menus", orphanRemoval=true)
     */
    private $commentairesMenuses;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->restaurants = new ArrayCollection();
        $this->commentairesMenuses = new ArrayCollection();
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
            $commentairesMenus->setMenus($this);
        }

        return $this;
    }

    public function removeCommentairesMenus(CommentairesMenus $commentairesMenus): self
    {
        if ($this->commentairesMenuses->removeElement($commentairesMenus)) {
            // set the owning side to null (unless already changed)
            if ($commentairesMenus->getMenus() === $this) {
                $commentairesMenus->setMenus(null);
            }
        }

        return $this;
    }

    public function getmoyenne(){
        $commentaires=$this->getCommentairesMenuses();
        $i=0;
        $somme=0;
        foreach($commentaires as $commentaire){
            $somme=$commentaire->getNote();
            $i++;
        }
        if($i==0){
            return null;
        }
        $moyenne=$somme/$i;
        return round($moyenne,1,PHP_ROUND_HALF_DOWN);
    }

    public function getBestCommentaire(){
        $commentaires=$this->getCommentairesMenuses();
        if($commentaires[0]){
            $bestCommentaire=$commentaires[0];
            $max = $bestCommentaire->getNote();
            foreach($commentaires as $commentaire){
                if($commentaire->getNote() > $max){
                    $max=$commentaire->getNote();
                    $bestCommentaire=$commentaire;
                }
            }
            return $bestCommentaire;
        }
        return null;
    }
    public function getworstCommentaire(){
        $commentaires=$this->getCommentairesMenuses();
        if($commentaires[0]){
            $min=$commentaires[0]->getNote();
            $worstCommentaire=$commentaires[0];
            foreach($commentaires as $commentaire){
                if($commentaire->getNote() < $min){
                    $min=$commentaire->getNote();
                    $worstCommentaire=$commentaire;
                }
            }
            return $worstCommentaire;
        }
        return null;
    }
}
