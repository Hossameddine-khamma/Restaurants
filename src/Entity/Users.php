<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true ,nullable=true)
     */
    private $Identifiant;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string" , nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, unique=true )
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $Adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class, inversedBy="Salarie")
     */
    private $Restaurant;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="users", orphanRemoval=true)
     */
    private $Commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Commandes::class, mappedBy="users", orphanRemoval=true)
     */
    private $Commandes;

    /**
     * @ORM\ManyToMany(targetEntity=Notes::class, inversedBy="users")
     */
    private $Notes;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Activation_Token;

    public function __construct()
    {
        $this->Commentaires = new ArrayCollection();
        $this->Commandes = new ArrayCollection();
        $this->Notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->Identifiant;
    }

    public function setIdentifiant(string $Identifiant): self
    {
        $this->Identifiant = $Identifiant;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Identifiant;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->Identifiant;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

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

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->Commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->Commentaires->contains($commentaire)) {
            $this->Commentaires[] = $commentaire;
            $commentaire->setUsers($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->Commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUsers() === $this) {
                $commentaire->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getCommandes(): Collection
    {
        return $this->Commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->Commandes->contains($commande)) {
            $this->Commandes[] = $commande;
            $commande->setUsers($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->Commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUsers() === $this) {
                $commande->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notes[]
     */
    public function getNotes(): Collection
    {
        return $this->Notes;
    }

    public function addNote(Notes $note): self
    {
        if (!$this->Notes->contains($note)) {
            $this->Notes[] = $note;
        }

        return $this;
    }

    public function removeNote(Notes $note): self
    {
        $this->Notes->removeElement($note);

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->Activation_Token;
    }

    public function setActivationToken(?string $Activation_Token): self
    {
        $this->Activation_Token = $Activation_Token;

        return $this;
    }
}
