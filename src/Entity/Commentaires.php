<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
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
     * @ORM\OneToOne(targetEntity=Commandes::class, mappedBy="Commentaires", cascade={"persist", "remove"})
     */
    private $commandes;

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

    public function getCommandes(): ?Commandes
    {
        return $this->commandes;
    }

    public function setCommandes(?Commandes $commandes): self
    {
        // unset the owning side of the relation if necessary
        if ($commandes === null && $this->commandes !== null) {
            $this->commandes->setCommentaires(null);
        }

        // set the owning side of the relation if necessary
        if ($commandes !== null && $commandes->getCommentaires() !== $this) {
            $commandes->setCommentaires($this);
        }

        $this->commandes = $commandes;

        return $this;
    }
}
