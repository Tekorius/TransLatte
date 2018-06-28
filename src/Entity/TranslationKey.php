<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TranslationKeyRepository")
 */
class TranslationKey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TranslationFile")
     * @ORM\JoinColumn(nullable=false)
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation", mappedBy="translationKey")
     */
    private $translations;


    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFile(): ?TranslationFile
    {
        return $this->file;
    }

    public function setFile(?TranslationFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getTranslations()
    {
        return $this->translations;
    }
}
