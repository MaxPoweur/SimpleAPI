<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
/*
User:
    firstname
    lastname
    alerts
Alert:
    From
    To
    min_hour_travel
    max_hour_travel
    jours:[]
    min_hour_alert
*/

/**
 * User
 *
 * @ApiResource
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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="from", type="string", length=10)
     */
   private $from;

   /**
    * @var string
    *
    * @ORM\Column(name="to", type="string", length=10)
    */
   private $to;

   /**
    * @var string
    *
    * @ORM\Column(name="min_hour_departure", type="string", length=5)
    */
    private $min_hour_departure;

    /**
     * @var string
     *
     * @ORM\Column(name="max_hour_departure", type="string", length=5)
     */
     private $max_hour_departure;

     /**
      * @var string
      *
      * @ORM\Column(name="min_hour_notification", type="string", length=5)
      */
      private $min_hour_notification;

      /**
       *
       * @ORM\Column(name="days", type="json_array")
       */
       private $days;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="alerts")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", nullable=false)
     */
    public $users;
       

    
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
    * Get the value of from
    *
    * @return  string
    */ 
   public function getFrom()
   {
      return $this->from;
   }

   /**
    * Set the value of from
    *
    * @param  string  $from
    *
    * @return  self
    */ 
   public function setFrom(string $from)
   {
      $this->from = $from;

      return $this;
   }

   /**
    * Get the value of to
    *
    * @return  string
    */ 
   public function getTo()
   {
      return $this->to;
   }

   /**
    * Set the value of to
    *
    * @param  string  $to
    *
    * @return  self
    */ 
   public function setTo(string $to)
   {
      $this->to = $to;

      return $this;
   }

    /**
     * Get the value of min_hour_departure
     *
     * @return  string
     */ 
    public function getMin_hour_departure()
    {
        return $this->min_hour_departure;
    }

    /**
     * Set the value of min_hour_departure
     *
     * @param  string  $min_hour_departure
     *
     * @return  self
     */ 
    public function setMin_hour_departure(string $min_hour_departure)
    {
        $this->min_hour_departure = $min_hour_departure;

        return $this;
    }

     /**
      * Get the value of max_hour_departure
      *
      * @return  string
      */ 
     public function getMax_hour_departure()
     {
          return $this->max_hour_departure;
     }

     /**
      * Set the value of max_hour_departure
      *
      * @param  string  $max_hour_departure
      *
      * @return  self
      */ 
     public function setMax_hour_departure(string $max_hour_departure)
     {
          $this->max_hour_departure = $max_hour_departure;

          return $this;
     }

      /**
       * Get the value of min_hour_notification
       *
       * @return  string
       */ 
      public function getMin_hour_notification()
      {
            return $this->min_hour_notification;
      }

      /**
       * Set the value of min_hour_notification
       *
       * @param  string  $min_hour_notification
       *
       * @return  self
       */ 
      public function setMin_hour_notification(string $min_hour_notification)
      {
            $this->min_hour_notification = $min_hour_notification;

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
     * Get the value of users
     */ 
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @return  self
     */ 
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }
}

