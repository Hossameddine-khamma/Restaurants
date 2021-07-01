<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotesRepository::class)
 */
class Notes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Valeurs;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="Notes")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Commandes::class, mappedBy="Notes", cascade={"persist", "remove"})
     */
    private $commandes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurs(): ?int
    {
        return $this->Valeurs;
    }

    public function setValeurs(int $Valeurs): self
    {
        $this->Valeurs = $Valeurs;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addNote($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeNote($this);
        }

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
            $this->commandes->setNotes(null);
        }

        // set the owning side of the relation if necessary
        if ($commandes !== null && $commandes->getNotes() !== $this) {
            $commandes->setNotes($this);
        }

        $this->commandes = $commandes;

        return $this;
    }
}
