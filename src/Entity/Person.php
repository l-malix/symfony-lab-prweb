<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @ORM\Table(name="person")
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="person_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $personId;

    /**
     * @var string
     *
     * @ORM\Column(name="person_firstname", type="string", length=128, nullable=false)
     */
    private $personFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="person_lastname", type="string", length=128, nullable=false)
     */
    private $personLastname;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="person_birthdate", type="date", nullable=true)
     */
    private $personBirthdate;

    public function getPersonId(): ?int
    {
        return $this->personId;
    }

    public function getPersonFirstname(): ?string
    {
        return $this->personFirstname;
    }

    public function setPersonFirstname(string $personFirstname): self
    {
        $this->personFirstname = $personFirstname;

        return $this;
    }

    public function getPersonLastname(): ?string
    {
        return $this->personLastname;
    }

    public function setPersonLastname(string $personLastname): self
    {
        $this->personLastname = $personLastname;

        return $this;
    }

    public function getPersonBirthdate(): ?\DateTimeInterface
    {
        return $this->personBirthdate;
    }

    public function setPersonBirthdate(?\DateTimeInterface $personBirthdate): self
    {
        $this->personBirthdate = $personBirthdate;

        return $this;
    }
}
