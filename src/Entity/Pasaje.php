<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Pasaje
 *
 * @ORM\Table(name="pasaje", indexes={@ORM\Index(name="fk_ruta_pasaje", columns={"ruta_id"}), @ORM\Index(name="fk_usuario_pasaje", columns={"usuario_id"})})
 * @ORM\Entity
 */
class Pasaje
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Groups("pasaje", "pasajeRuta", "pasajeUsuario")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="salida", type="datetime", nullable=false)
     * 
     * @Groups("pasaje", "pasajeRuta", "pasajeUsuario")
     */
    private $salida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="llegada", type="datetime", nullable=false)
     * 
     * @Groups("pasaje", "pasajeRuta", "pasajeUsuario")
     */
    private $llegada;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     * 
     * @Groups("pasaje", "pasajeRuta", "pasajeUsuario")
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="habitacion", type="string", length=20, nullable=false)
     * 
     * @Groups("pasaje", "pasajeRuta", "pasajeUsuario")
     */
    private $habitacion;

    /**
     * @var Ruta
     *
     * @ORM\ManyToOne(targetEntity="Ruta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ruta_id", referencedColumnName="id")
     * })
     * 
     * @Groups("pasaje", "pasajeUsuario")
     */
    private $ruta;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     * 
     * @Groups("pasaje", "pasajeRuta")
     */
    private $usuario;

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
     * Get the value of precio
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of habitacion
     */
    public function getHabitacion(): string
    {
        return $this->habitacion;
    }

    /**
     * Set the value of habitacion
     */
    public function setHabitacion(string $habitacion): self
    {
        $this->habitacion = $habitacion;

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

    /**
     * Get the value of usuario
     */
    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario(Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
