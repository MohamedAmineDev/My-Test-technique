<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Entity
 * @copyright 2023 Quantic Factory
 */

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cette classe  représente le modèle Order
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    //#[ORM\GeneratedValue]
    #[ORM\Column(type: Types::GUID)]
    private ?string $id = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $currency = null;

    #[ORM\ManyToOne(inversedBy: 'orders', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $deliverTo = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $orderNumber = null;

    #[ORM\OneToMany(mappedBy: 'theOrder', targetEntity: SalesOrderLine::class, orphanRemoval: true, fetch: 'EAGER')]
    private Collection $salesOrderLines;

    public function __construct()
    {
        $this->salesOrderLines = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDeliverTo(): ?Contact
    {
        return $this->deliverTo;
    }

    public function setDeliverTo(?Contact $deliverTo): static
    {
        $this->deliverTo = $deliverTo;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?string $orderNumber): static
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return Collection<int, SalesOrderLine>
     */
    public function getSalesOrderLines(): Collection
    {
        return $this->salesOrderLines;
    }

    public function addSalesOrderLine(SalesOrderLine $salesOrderLine): static
    {
        if (!$this->salesOrderLines->contains($salesOrderLine)) {
            $this->salesOrderLines->add($salesOrderLine);
            $salesOrderLine->setTheOrder($this);
        }

        return $this;
    }

    public function removeSalesOrderLine(SalesOrderLine $salesOrderLine): static
    {
        if ($this->salesOrderLines->removeElement($salesOrderLine)) {
            // set the owning side to null (unless already changed)
            if ($salesOrderLine->getTheOrder() === $this) {
                $salesOrderLine->setTheOrder(null);
            }
        }

        return $this;
    }
    public function cleanSalesOrderLine(): static
    {
        $this->salesOrderLines = new ArrayCollection();
        return $this;
    }
}
