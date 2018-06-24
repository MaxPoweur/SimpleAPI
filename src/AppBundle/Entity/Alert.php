<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * User
 *
 * @ApiResource(
 *      attributes={
 *          "filters"={"generic.search", "generic.range", "generic.order", "generic.date"},
 *          "normalization_context"={"groups"={"alertRead"}},
 *          "denormalization_context"={"groups"={"alertWrite"}}
 *       },
 *      itemOperations={
 *          "put"={"method"="PUT", "denormalization_context"={"groups"={"putAlert"}}},
 *          "delete"={"method"="DELETE"},
 *          "get"={"method"="GET"},
 *      }
 *  )
 * @ORM\Table(name="alerts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlertsRepository")
 */
class Alert
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"alertRead"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="departure", type="string", length=10)
     * @Groups({"alertRead", "alertWrite", "putAlert"})
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "The departure must be at least {{ limit }} characters long",
     *      maxMessage = "The departure cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *      pattern="/[^a-zA-Z]/",
     *      match=false,
     *      message="The departure must only contains letters"
     * )
     */
    private $departure;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival", type="string", length=10)
     * @Groups({"alertRead", "alertWrite", "putAlert"})
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "The arrival must be at least {{ limit }} characters long",
     *      maxMessage = "The arrival cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *      pattern="/[^a-zA-Z]/",
     *      match=false,
     *      message="The arrival must only contains letters"
     * )
     */
    private $arrival;

    /**
     * @var string
     *
     * @ORM\Column(name="minHourDeparture", type="string", length=5)
     * @Groups({"alertRead", "alertWrite", "putAlert"})
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "The minh must be at least {{ limit }} characters long",
     *      maxMessage = "The minh name cannot be longer than {{ limit }} characters"
     * )
     */
    private $minHourDeparture;

    /**
     * @var string
     *
     * @ORM\Column(name="maxHourDeparture", type="string", length=5)
     * @Groups({"alertRead", "alertWrite", "putAlert"})
     */
    private $maxHourDeparture;

    /**
     * @var string
     *
     * @ORM\Column(name="minHourNotification", type="string", length=5)
     * @Groups({"alertRead", "alertWrite", "putAlert"})
     */
    private $minHourNotification;

    /**
     *
     * @ORM\Column(name="days", type="json_array")
     * @Groups({"alertRead", "alertWrite", "putAlert"})
     * @Assert\Count(
     *      min = 1,
     *      max = 7,
     *      minMessage = "You must specify at least one day",
     *      maxMessage = "You cannot specify more than {{ limit }} emails"
     * )
     */
    private $days;

    /**
     * @Assert\Callback
     */
    public function validateDays(ExecutionContextInterface $context, $payload)
    {
        // somehow you have an array of "fake names"
        $days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];

        foreach ($this->getDays() as $day) {
            if (count(preg_grep("/" . $day . "/i", $days)) == 0) {
                $context->buildViolation('Please provide a valid day')
                    ->atPath('days')
                    ->addViolation();
            }
        }
    }

    /**
     * @Assert\Callback
     */
    public function validateHours(ExecutionContextInterface $context, $payload)
    {
        $minHourDepartureCorrect = true;
        $maxHourDepartureCorrect = true;
        $minHourNotificationCorrect = true;
        if (!self::validateHour($this->getMinHourDeparture())) {
            $context->buildViolation('Please provide a correct time (HH:MM)')
                ->atPath('minHourDeparture')
                ->addViolation();
            $minHourDepartureCorrect = false;
        }
        if (!self::validateHour($this->getMaxHourDeparture())) {
            $context->buildViolation('Please provide a correct time (HH:MM)')
                ->atPath('maxHourDeparture')
                ->addViolation();
            $maxHourDepartureCorrect = false;
        }
        if (!self::validateHour($this->getMinHourNotification())) {
            $context->buildViolation('Please provide a correct time (HH:MM)')
                ->atPath('minHourNotification')
                ->addViolation();
            $minHourNotificationCorrect = false;
        }

        if($minHourDepartureCorrect && $maxHourDepartureCorrect && self::compareTimes($this->getMinHourDeparture(), $this->getMaxHourDeparture()) != -1)
            $context->buildViolation('The minimum hour of departure should be before the maximum hour of departure')
            ->atPath('minHourDeparture')
            ->addViolation();

        if($minHourDepartureCorrect && $minHourNotificationCorrect && self::compareTimes($this->getMinHourDeparture(), $this->getMinHourNotification()) != 1)
            $context->buildViolation('The minimum hour of notification should be before the minimum hour of departure')
            ->atPath('minHourNotification')
            ->addViolation();
    }

    /*
     *    We check the hour is in the format HH:MM
     */
    public static function validateHour($time)
    {
        return preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $time);
    }

    /*
     *    We compare two times
     */
    public static function compareTimes($time1, $time2)
    {
        list($hour1, $mins1) = explode(":", $time1);
        list($hour2, $mins2) = explode(":", $time2);
        if($hour1<$hour2)
            return -1;
        else if($hour1>$hour2)
            return 1;
        else
        {
            if($mins1<$mins2)
                return -1;
            else if($mins1>$mins2)
                return 1;
            else
                return 0;
        }
    }

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="alerts")
     * @Assert\NotNull(message="Alert should be associated with an user")
     * @ORM\JoinColumns({
     * })
     * @Groups({"alertRead", "alertWrite"})
     */
    public $user;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     * @Groups({"alertRead"})
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
     * Get the value of departure
     *
     * @return  string
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set the value of departure
     *
     * @param  string  $departure
     *
     * @return  self
     */
    public function setDeparture(string $departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get the value of arrival
     *
     * @return  string
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set the value of arrival
     *
     * @param  string  $arrival
     *
     * @return  self
     */
    public function setArrival(string $arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get the value of days
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set the value of days
     *
     * @return  self
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
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
     * Get the value of minHourDeparture
     *
     * @return  string
     */
    public function getMinHourDeparture()
    {
        return $this->minHourDeparture;
    }

    /**
     * Set the value of minHourDeparture
     *
     * @param  string  $minHourDeparture
     *
     * @return  self
     */
    public function setMinHourDeparture(string $minHourDeparture)
    {
        $this->minHourDeparture = $minHourDeparture;

        return $this;
    }

    /**
     * Get the value of maxHourDeparture
     *
     * @return  string
     */
    public function getMaxHourDeparture()
    {
        return $this->maxHourDeparture;
    }

    /**
     * Set the value of maxHourDeparture
     *
     * @param  string  $maxHourDeparture
     *
     * @return  self
     */
    public function setMaxHourDeparture(string $maxHourDeparture)
    {
        $this->maxHourDeparture = $maxHourDeparture;

        return $this;
    }

    /**
     * Get the value of minHourNotification
     *
     * @return  string
     */
    public function getMinHourNotification()
    {
        return $this->minHourNotification;
    }

    /**
     * Set the value of minHourNotification
     *
     * @param  string  $minHourNotification
     *
     * @return  self
     */
    public function setMinHourNotification(string $minHourNotification)
    {
        $this->minHourNotification = $minHourNotification;

        return $this;
    }
}
