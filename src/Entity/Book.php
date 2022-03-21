<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 * @ORM\Table(name="book")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="book_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bookId;

    /**
     * @var string
     *
     * @ORM\Column(name="book_title", type="string", length=256, nullable=false)
     */
    private $bookTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="book_authors", type="string", length=256, nullable=false)
     */
    private $bookAuthors;

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function getBookTitle(): ?string
    {
        return $this->bookTitle;
    }

    public function setBookTitle(string $bookTitle): self
    {
        $this->bookTitle = $bookTitle;

        return $this;
    }

    public function getBookAuthors(): ?string
    {
        return $this->bookAuthors;
    }

    public function setBookAuthors(string $bookAuthors): self
    {
        $this->bookAuthors = $bookAuthors;

        return $this;
    }


}
