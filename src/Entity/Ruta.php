<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="origen", type="string", length=45, nullable=false)
     */
    private $origen;

    /**
     * @var string
     *
     * @ORM\Column(name="destino", type="string", length=45, nullable=false)
     */
    private $destino;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="salida", type="datetime", nullable=false)
     */
    private $salida;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="llegada", type="datetime", nullable=false)
     */
    private $llegada;

    /**
     * @var Tren
     *
     * @ORM\ManyToOne(targetEntity="Tren")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tren_id", referencedColumnName="id")
     * })
     */
    private $tren;

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
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
