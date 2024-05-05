<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PuntoInteres
 *
 * @ORM\Table(name="punto_interes", indexes={@ORM\Index(name="fk_punto_interes_estacion", columns={"estacion_id"})})
 * @ORM\Entity
 */
class PuntoInteres
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=150, nullable=false)
     */
    private $direccion;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitud;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitud;

    /**
     * @var Estacion
     *
     * @ORM\ManyToOne(targetEntity="Estacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estacion_id", referencedColumnName="id")
     * })
     */
    private $estacion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PlanViaje", mappedBy="puntoInteres")
     */
    private $planViaje = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->planViaje = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Get the value of estacion
     */
    public function getEstacion(): Estacion
    {
        return $this->estacion;
    }

    /**
     * Set the value of estacion
     */
    public function setEstacion(Estacion $estacion): self
    {
        $this->estacion = $estacion;

        return $this;
    }

    /**
     * Get the value of planViaje
     */
    public function getPlanViaje(): \Doctrine\Common\Collections\Collection
    {
        return $this->planViaje;
    }

    /**
     * Set the value of planViaje
     */
    public function setPlanViaje(\Doctrine\Common\Collections\Collection $planViaje): self
    {
        $this->planViaje = $planViaje;

        return $this;
    }
}