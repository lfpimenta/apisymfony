<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupRepository")
 */
class UserGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groups", inversedBy="userGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getGroupid(): ?Groups
    {
        return $this->groupid;
    }

    public function setGroupid(?Groups $groups): self
    {
        $this->groupid = $groups;

        return $this;
    }
}
