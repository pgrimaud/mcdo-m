<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?District $district = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: ProductRestaurant::class)]
    private Collection $productRestaurants;

    public function __construct()
    {
        $this->productRestaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Collection<int, ProductRestaurant>
     */
    public function getProductRestaurants(): Collection
    {
        return $this->productRestaurants;
    }

    public function addProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if (!$this->productRestaurants->contains($productRestaurant)) {
            $this->productRestaurants->add($productRestaurant);
            $productRestaurant->setRestaurant($this);
        }

        return $this;
    }

    public function removeProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if ($this->productRestaurants->removeElement($productRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($productRestaurant->getRestaurant() === $this) {
                $productRestaurant->setRestaurant(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
