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

}
