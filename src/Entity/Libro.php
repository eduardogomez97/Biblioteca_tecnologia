<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LibroRepository::class)
 */
class Libro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_publicacion;

    /**
     * @ORM\Column(type="integer")
     */
    private $ejemplares;

    /**
     * @var Biblioteca
     *
     * @ORM\ManyToOne(targetEntity="Biblioteca", inversedBy="libros")
     * @ORM\JoinColumn(name="biblioteca_id", referencedColumnName="id", nullable=false)
     */
    private $biblioteca;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }

    public function getEjemplares(): ?int
    {
        return $this->ejemplares;
    }

    public function setEjemplares(int $ejemplares): self
    {
        $this->ejemplares = $ejemplares;

        return $this;
    }
    public function getBiblioteca(): ?Biblioteca
    {
        return $this->biblioteca;
    }

    public function setBiblioteca($biblioteca): void
    {
        $this->biblioteca = $biblioteca;
    }
}
