<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ApiResource(
 *      attributes={
 *          "filters"={"generic.search", "generic.range", "generic.order", "generic.date"},
 *          "normalization_context"={"groups"={"userRead"}},
 *          "denormalization_context"={"groups"={"userWrite"}}
 *                  }
 *              )
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"userRead", "alertRead"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Groups({"userRead", "userWrite", "alertRead"})
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "The first name must be at least {{ limit }} characters long",
     *      maxMessage = "The first name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *      pattern="/[^a-zA-Z]/",
     *      match=false,
     *      message="The first name must only contains letters"
     * )
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Groups({"userRead", "userWrite", "alertRead"})
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "The last name must be at least {{ limit }} characters long",
     *      maxMessage = "The last name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *      pattern="/[^a-zA-Z]/",
     *      match=false,
     *      message="The last name must only contains letters"
     * )
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity="Alert", mappedBy="user")
     * @Groups({"userRead"})
     */
    public $alerts;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Groups({"userRead"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime  $createdAt
     *
     * @return  self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of alerts
     */
    public function getAlerts()
    {
        return $this->alerts;
    }
}
