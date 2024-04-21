<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

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

}
