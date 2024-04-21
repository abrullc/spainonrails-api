<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="poblacion", type="string", length=100, nullable=false)
     */
    private $poblacion;

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
     * @var Ruta
     *
     * @ORM\ManyToOne(targetEntity="Ruta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ruta_id", referencedColumnName="id")
     * })
     */
    private $ruta;


}
