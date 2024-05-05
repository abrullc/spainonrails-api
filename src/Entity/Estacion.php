<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Estacion
 *
 * @ORM\Table(name="estacion", indexes={@ORM\Index(name="fk_estacion_ruta", columns={"ruta_id"})})
 * @ORM\Entity
 */
class Estacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Groups("estacion")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     * 
     * @Groups("estacion")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="poblacion", type="string", length=100, nullable=false)
     * 
     * @Groups("estacion")
     */
    private $poblacion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=150, nullable=false)
     * 
     * @Groups("estacion")
     */
    private $direccion;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="float", precision=10, scale=0, nullable=false)
     * 
     * @Groups("estacion")
     */
    private $longitud;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="float", precision=10, scale=0, nullable=false)
     * 
     * @Groups("estacion")
     */
    private $latitud;

    /**
     * @var Ruta
     *
     * @ORM\ManyToOne(targetEntity="Ruta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ruta_id", referencedColumnName="id")
     * })
     * 
     * @Groups("estacion")
     */
    private $ruta;


    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of poblacion
     */
    public function getPoblacion(): string
    {
        return $this->poblacion;
    }

    /**
     * Set the value of poblacion
     */
    public function setPoblacion(string $poblacion): self
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     */
    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of longitud
     */
    public function getLongitud(): float
    {
        return $this->longitud;
    }

    /**
     * Set the value of longitud
     */
    public function setLongitud(float $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get the value of latitud
     */
    public function getLatitud(): float
    {
        return $this->latitud;
    }

    /**
     * Set the value of latitud
     */
    public function setLatitud(float $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get the value of ruta
     */
    public function getRuta(): Ruta
    {
        return $this->ruta;
    }

    /**
     * Set the value of ruta
     */
    public function setRuta(Ruta $ruta): self
    {
        $this->ruta = $ruta;

        return $this;
    }
}