<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * PlanViaje
 *
 * @ORM\Table(name="plan_viaje")
 * @ORM\Entity
 */
class PlanViaje
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @Groups("planViaje")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=70, nullable=false)
     * 
     * @Groups("planViaje")
     */
    private $nombre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PuntoInteres", inversedBy="planViaje")
     * @ORM\JoinTable(name="plan_viaje_punto_interes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="plan_viaje_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="punto_interes_id", referencedColumnName="id")
     *   }
     * )
     */
    private $puntoInteres = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="planViaje")
     * @ORM\JoinTable(name="plan_viaje_usuario",
     *   joinColumns={
     *     @ORM\JoinColumn(name="plan_viaje_id", referencedColumnName="id")
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
        $this->puntoInteres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get the value of puntoInteres
     */
    public function getPuntoInteres(): \Doctrine\Common\Collections\Collection
    {
        return $this->puntoInteres;
    }

    /**
     * Set the value of puntoInteres
     */
    public function setPuntoInteres(\Doctrine\Common\Collections\Collection $puntoInteres): self
    {
        $this->puntoInteres = $puntoInteres;

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
