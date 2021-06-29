<?php

namespace App\Entity;

use App\Repository\BibliotecaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BibliotecaRepository::class)
 */
class Biblioteca
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
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_trabajadores;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_fundacion;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Libro", mappedBy="biblioteca", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $libros;

    public function __construct()
    {
        $this->fecha_fundacion = new \DateTime();
        $this->libros = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNumTrabajadores(): ?int
    {
        return $this->num_trabajadores;
    }

    public function setNumTrabajadores(int $num_trabajadores): self
    {
        $this->num_trabajadores = $num_trabajadores;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getFechaFundacion(): ?\DateTimeInterface
    {
        return $this->fecha_fundacion;
    }

    public function setFechaFundacion(\DateTimeInterface $fecha_fundacion): self
    {
        $this->fecha_fundacion = $fecha_fundacion;

        return $this;
    }

    public function getLibros(): Collection
    {
        return $this->libros;
    }

    public function addLibro(Libro $libro)
    {
        if (! $this->libros->contains($libro)) {
            $this->libros->add($libro);
            $libro->setBiblioteca($this);
        }
    }

    public function removeLibro(Libro $libro)
    {
        if ($this->libros->contains($libro)) {
            $this->libros->removeElement($libro);
            $libro->setBiblioteca(null);
        }
    }
}
