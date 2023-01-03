<?php

namespace App\Entity;

use App\Repository\MemberPoseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberPoseRepository::class)
 */
class MemberPose
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
    private $member_pose_name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $member_pose_memo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $member_name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $member_pose_advice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $member_pose_image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemberPoseName(): ?string
    {
        return $this->member_pose_name;
    }

    public function setMemberPoseName(string $member_pose_name): self
    {
        $this->member_pose_name = $member_pose_name;

        return $this;
    }

    public function getMemberPoseMemo(): ?string
    {
        return $this->member_pose_memo;
    }

    public function setMemberPoseMemo(?string $member_pose_memo): self
    {
        $this->member_pose_memo = $member_pose_memo;

        return $this;
    }

    public function getMemberName(): ?string
    {
        return $this->member_name;
    }

    public function setMemberName(string $member_name): self
    {
        $this->member_name = $member_name;

        return $this;
    }

    public function getMemberPoseAdvice(): ?string
    {
        return $this->member_pose_advice;
    }

    public function setMemberPoseAdvice(?string $member_pose_advice): self
    {
        $this->member_pose_advice = $member_pose_advice;

        return $this;
    }

    public function getMemberPoseImage(): ?string
    {
        return $this->member_pose_image;
    }

    public function setMemberPoseImage(?string $member_pose_image): self
    {
        $this->member_pose_image = $member_pose_image;

        return $this;
    }
}
