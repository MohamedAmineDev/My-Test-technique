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

use App\Repository\SalesOrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cette classe  représente le modèle SalesOrderLine
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

#[ORM\Entity(repositoryClass: SalesOrderLineRepository::class)]
class SalesOrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?float $discount = null;

    #[ORM\Column]
    private ?int $quantity = null;

    //#[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'salesOrderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $theOrder = null;

    //#[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'salesOrderLines', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    public function __construct()
    {
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): ?static
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

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
    public function getTheOrder(): ?Order
    {
        return $this->theOrder;
    }

    public function setTheOrder(?Order $theOrder): static
    {
        $this->theOrder = $theOrder;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }
}
