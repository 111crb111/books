<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete"}
 * )
 *
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *              "name": "ipartial",
 *              "author": "ipartial",
 *              "genre": "iexact"
 *          }
 *     )
 *
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title
     *
     * @ORM\Column(type="string", length=500)
     */
    private $name;

    /**
     * Publisher
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publisher;

    /**
     * Author
     *
     * @ORM\Column(type="string", length=128)
     */
    private $author;

    /**
     * Genre
     *
     * @ORM\Column(type="string", length=64)
     */
    private $genre;

    /**
     * First publish year
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $publishYear;

    /**
     * Amount of words in the book
     *
     * @ORM\Column(type="integer")
     */
    private $words;

    /**
     * Book price in US Dollars
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    public function getId(): ?int
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

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublishYear(): ?int
    {
        return $this->publishYear;
    }

    public function setPublishYear(?int $publishYear): self
    {
        $this->publishYear = $publishYear;

        return $this;
    }

    public function getWords(): ?int
    {
        return $this->words;
    }

    public function setWords(int $words): self
    {
        $this->words = $words;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
