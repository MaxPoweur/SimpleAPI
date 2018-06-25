<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
class User extends BaseUser
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"userRead", "alertRead"})
     */
    protected $id;

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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "The last name must be at least {{ limit }} characters long",
     *      maxMessage = "The last name cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *      pattern="/[^a-zA-Z]/",
     *      match=false,
     *      message="The last name must only contain letters"
     * )
     */
    private $lastname;

    /**
     * @var string
     * @Groups({"userWrite"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 12,
     *      minMessage = "The password must be at least {{ limit }} characters long",
     *      maxMessage = "The password cannot be longer than {{ limit }} characters"
     * )
     */
     protected $plainPassword;

     /**
     * @Groups({"userRead", "userWrite"})
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $email;

     /**
     * @Groups({"userRead", "userWrite"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 12,
     *      minMessage = "The username must be at least {{ limit }} characters long",
     *      maxMessage = "The username cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *      pattern="/[^\w]/",
     *      match=false,
     *      message="The last name cannot contain special characters"
     * )
     */
     protected $username;


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
        parent::__construct();
        $this->createdAt = new \DateTime();
    }

    /**
     * @Assert\Callback
     */
     public function validatePassword(ExecutionContextInterface $context, $payload)
     {
        $uppercase = preg_match('@[A-Z]@', $this->plainPassword);
        $lowercase = preg_match('@[a-z]@', $this->plainPassword);
        $specialChar = preg_match('@[^\w]@', $this->plainPassword) || preg_match('@[\d]@', $this->plainPassword);
        
        if(!$uppercase)
        {
            $context->buildViolation('The password should contain at least one uppercase letter')
                ->atPath('plainPassword')
                ->addViolation();
        }
        if(!$lowercase)
        {
            $context->buildViolation('The password should contain at least one lowercase letter')
                ->atPath('plainPassword')
                ->addViolation();
        }
        if(!$specialChar)
        {
            $context->buildViolation('The password should contain at least one special character/number')
                ->atPath('plainPassword')
                ->addViolation();
        }
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

    public function isUser(UserInterface $user = null): bool
    {
        return $user instanceof self && $user->id === $this->id;
    }
}
