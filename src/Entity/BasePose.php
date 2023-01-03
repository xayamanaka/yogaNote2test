<?php

namespace App\Entity;

use App\Repository\BasePoseRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=BasePoseRepository::class)
 */
class BasePose
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $base_pose_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $base_pose_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $base_pose_category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $base_pose_description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getBasePoseName(): ?string
    {
        return $this->base_pose_name;
    }

    public function setBasePoseName(string $base_pose_name): self
    {
        $this->base_pose_name = $base_pose_name;

        return $this;
    }

    public function getBasePoseImage(): ?string
    {
        return $this->base_pose_image;
    }

    public function setBasePoseImage(?string $base_pose_image): self
    {
        $this->base_pose_image = $base_pose_image;

        return $this;
    }

    public function getBasePoseCategory(): ?string
    {
        return $this->base_pose_category;
    }

    public function setBasePoseCategory(?string $base_pose_category): self
    {
        $this->base_pose_category = $base_pose_category;

        return $this;
    }

    public function getBasePoseDescription(): ?string
    {
        return $this->base_pose_description;
    }

    public function setBasePoseDescription(?string $base_pose_description): self
    {
        $this->base_pose_description = $base_pose_description;

        return $this;
    }
}
