<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *       "get"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Vous n'avez pas access à cette Ressource"},
 *       "post"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Vous n'avez pas access à cette Ressource"} *       
 *     },
 *     itemOperations={
 *        "get"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Vous n'avez pas access à cette Ressource"},
 *        "put"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Vous n'avez pas access à cette Ressource"},
 *        "delete"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Vous n'avez pas access à cette Ressource"}
 *     }
 * )
 */
class Profil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank()
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     *  @ApiSubResource()
     */
    private $users;



    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }






}
