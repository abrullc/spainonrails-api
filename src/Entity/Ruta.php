<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Ruta
 *
 * @ORM\Table(name="ruta", indexes={@ORM\Index(name="fk_ruta_tren", columns={"tren_id"})})
 * @ORM\Entity
 */
class Ruta
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Groups("ruta")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="origen", type="string", length=45, nullable=false)
     * 
     * @Groups("ruta")
     */
    private $origen;

    /**
     * @var string
     *
     * @ORM\Column(name="destino", type="string", length=45, nullable=false)
     * 
     * @Groups("ruta")
     */
    private $destino;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="salida", type="datetime", nullable=false)
     * 
     * @Groups("ruta")
     */
    private $salida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="llegada", type="datetime", nullable=false)
     * 
     * @Groups("ruta")
     */
    private $llegada;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=255, nullable=false)
     * 
     * @Groups("ruta")
     */
    private $descripcion;

    /**
     * @var Tren|null
     *
     * @ORM\ManyToOne(targetEntity="Tren")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tren_id", referencedColumnName="id")
     * })
     * 
     * @Groups("ruta")
     */
    private $tren;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Estacion", inversedBy="ruta")
     * @ORM\JoinTable(name="parada",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ruta_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="estacion_id", referencedColumnName="id")
     *   }
     * )
     */
    private $estacion = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="ruta")
     * @ORM\JoinTable(name="pasaje",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ruta_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     *   }
     * )
     */
    private $usuario = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estacion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get the value of origen
     */
    public function getOrigen(): string
    {
        return $this->origen;
    }

    /**
     * Set the value of origen
     */
    public function setOrigen(string $origen): self
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get the value of destino
     */
    public function getDestino(): string
    {
        return $this->destino;
    }

    /**
     * Set the value of destino
     */
    public function setDestino(string $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get the value of salida
     */
    public function getSalida(): \DateTime
    {
        return $this->salida;
    }

    /**
     * Set the value of salida
     */
    public function setSalida(\DateTime $salida): self
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get the value of llegada
     */
    public function getLlegada(): \DateTime
    {
        return $this->llegada;
    }

    /**
     * Set the value of llegada
     */
    public function setLlegada(\DateTime $llegada): self
    {
        $this->llegada = $llegada;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of tren
     */
    public function getTren(): ?Tren
    {
        return $this->tren;
    }

    /**
     * Set the value of tren
     */
    public function setTren(?Tren $tren): self
    {
        $this->tren = $tren;

        return $this;
    }

    /**
     * Get the value of estacion
     */
    public function getEstacion(): \Doctrine\Common\Collections\Collection
    {
        return $this->estacion;
    }

    /**
     * Set the value of estacion
     */
    public function setEstacion(\Doctrine\Common\Collections\Collection $estacion): self
    {
        $this->estacion = $estacion;

        return $this;
    }

    /**
     * Get the value of usuario
     */
    public function getUsuario(): \Doctrine\Common\Collections\Collection
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario(\Doctrine\Common\Collections\Collection $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
