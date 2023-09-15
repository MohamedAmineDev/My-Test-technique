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

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cette classe  représente le modèle Article
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    // #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::GUID)]
    private ?string $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $articleDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $unitDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $unitCode = null;

    #[ORM\Column]
    private ?float $unitPrice = null;

    #[ORM\Column]
    private ?float $vatAmount = null;

    #[ORM\Column]
    private ?float $vatPercentage = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: SalesOrderLine::class, orphanRemoval: true, cascade: ["persist"])]
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

    public function getArticleDescription(): ?string
    {
        return $this->articleDescription;
    }

    public function setArticleDescription(string $articleDescription): static
    {
        $this->articleDescription = $articleDescription;

        return $this;
    }
    public function getUnitDescription(): ?string
    {
        return $this->unitDescription;
    }

    public function setUnitDescription(string $unitDescription): static
    {
        $this->unitDescription = $unitDescription;

        return $this;
    }

    public function getUnitCode(): ?string
    {
        return $this->unitCode;
    }

    public function setUnitCode(string $unitCode): static
    {
        $this->unitCode = $unitCode;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getVatAmount(): ?float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): static
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    public function getVatPercentage(): ?float
    {
        return $this->vatPercentage;
    }

    public function setVatPercentage(float $vatPercentage): static
    {
        $this->vatPercentage = $vatPercentage;

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
            $salesOrderLine->setArticle($this);
        }

        return $this;
    }

    public function removeSalesOrderLine(SalesOrderLine $salesOrderLine): static
    {
        if ($this->salesOrderLines->removeElement($salesOrderLine)) {
            // set the owning side to null (unless already changed)
            if ($salesOrderLine->getArticle() === $this) {
                $salesOrderLine->setArticle(null);
            }
        }

        return $this;
    }
}
