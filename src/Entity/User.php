<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *   collectionOperations={
 *     "get"={"security"="is_granted('ROLE_ADMIN')"},
 *     "post"={"security"="is_granted('ROLE_ADMIN')"},   
 *     "get_apprenants"={
 *        "method"="GET",
 *        "path"="/apprenants" ,
 *        "normalization_context"={"groups":"apprenant:read"},
 *        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="apprenant_liste"
 *     }, 
 *    "get_formateurs"={
 *        "method"="GET",
 *        "path"="/formateurs" ,
 *        "normalization_context"={"groups":"formateur:read"},
 *        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="formateur_liste"
 *     },
 *     "post_ajouterApprenant"={
 *        "method"="POST",
 *        "path"="/ajouterApprenant",
 *        "denormalization_context"={"groups":"apprenant:put"},
 *        "access_control"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="ajouter_apprenant"
 *      }
 *   },
 *   itemOperations={
 *     "get"={"security"="is_granted('ROLE_ADMIN')"},
 *     "put"={"security"="is_granted('ROLE_ADMIN')"},
 *     "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     "delete_supprimerApprenant"={
 *        "method"="DELETE",
 *        "path"="/supprimerApprenant/{id}" ,
 *        "normalization_context"={"groups":"apprenant:read"},
 *        "access_control"="(is_granted('ROLE_ADMIN') )",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="supprimerApprenant"
 *     },
 *     "put_modifierApprenant"={
 *        "method"="PUT",
 *        "path"="/modifierApprenant/{id}" ,
 *        "normalization_context"={"groups":"apprenant:read"},
 *        "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT'))",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="modifierApprenant",
 *     },     
 *    "get_apprenant"={
 *       "method"="GET",
 *       "path"="/apprenant/{id}" ,
 *       "normalization_context"={"groups":"apprenant:read"},
 *       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_CM') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))",
 *       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *       "route_name"="apprenant_liste_one",
 *     },
 *     "get_formateur"={
 *       "method"="GET",
 *       "path"="/formateur/{id}" ,
 *       "normalization_context"={"groups":"formateur:read"},
 *       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *       "route_name"="formateur_liste_one",
 *     }, 
 *     "put_modifierFormateur"={
 *        "method"="PUT",
 *        "path"="/modifierFormateur/{id}" ,
 *        "normalization_context"={"groups":"formateur:read"},
 *        "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="modifierFormateur",
 *     },   
 *   }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"apprenant:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Groups({"apprenant:read"})
     */
    private $email;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"apprenant:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"apprenant:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"apprenant:read"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank()
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $login;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Assert\NotBlank()
     */
    private $profil;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $profile=$this->getProfil();
        $p= $profile->getLibelle();
        $rule="ROLE_".strtoupper($p);
        // guarantee every user at least has ROLE_USER
        $roles[] = $rule;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password,PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getProfil(): ?profil
    {
        return $this->profil;
    }

    public function setProfil(?profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }
}
