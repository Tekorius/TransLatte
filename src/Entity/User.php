<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * User email
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * Hashed password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * Roles assigned to the user
     *
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectUser", mappedBy="user", orphanRemoval=true)
     */
    private $projectUsers;


    public function __construct()
    {
        $this->projectUsers = new ArrayCollection();
    }


    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->roles,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->roles
            ) = unserialize($serialized);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return Collection|ProjectUser[]
     */
    public function getProjectUsers(): Collection
    {
        return $this->projectUsers;
    }

    public function addProjectUser(ProjectUser $projectUser): self
    {
        if (!$this->projectUsers->contains($projectUser)) {
            $this->projectUsers[] = $projectUser;
            $projectUser->setUser($this);
        }

        return $this;
    }

    public function removeProjectUser(ProjectUser $projectUser): self
    {
        if ($this->projectUsers->contains($projectUser)) {
            $this->projectUsers->removeElement($projectUser);
            // set the owning side to null (unless already changed)
            if ($projectUser->getUser() === $this) {
                $projectUser->setUser(null);
            }
        }

        return $this;
    }
}
