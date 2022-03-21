<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Book as Book;
use App\Entity\Person as Person;

/**
 * Borrow
 * @ORM\Entity(repositoryClass="App\Repository\BorrowRepository")
 * @ORM\Table(name="borrow", indexes={@ORM\Index(name="IDX_55DBA8B016A2B381", columns={"book_id"}), @ORM\Index(name="IDX_55DBA8B0217BBB47", columns={"person_id"})})
 */
class Borrow
{
    /**
     * @var int
     * 
     * @ORM\Column(name="borrow_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $borrowId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="borrow_date", type="date", nullable=false)
     */
    private $borrowDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="borrow_return", type="date", nullable=true)
     */
    private $borrowReturn;

    /**
     * @var \Book
     *
     * @ORM\ManyToOne(targetEntity="Book")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_id", referencedColumnName="book_id")
     * })
     */
    private $book;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="person_id", referencedColumnName="person_id")
     * })
     */
    private $person;

    public function getBorrowId(): ?int
    {
        return $this->borrowId;
    }

    public function getBorrowDate(): ?\DateTimeInterface
    {
        return $this->borrowDate;
    }

    public function setBorrowDate(\DateTimeInterface $borrowDate): self
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    public function getBorrowReturn(): ?\DateTimeInterface
    {
        return $this->borrowReturn;
    }

    public function setBorrowReturn(?\DateTimeInterface $borrowReturn): self
    {
        $this->borrowReturn = $borrowReturn;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }
}
