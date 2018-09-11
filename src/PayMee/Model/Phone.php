<?php

namespace PayMee\Model;
use \Exception;

/**
 * Class Phone
 *
 * @package PayMee\Model
 */
class Phone extends AbstractModel
{
	const TYPE_MOBILE = 'MOBILE';
	const TYPE_HOME = 'HOME';
	const TYPE_WORK = 'WORK';
	const TYPE_OTHER = 'OTHER';
	
	/**
	* @var string
	*/
   public $type;
   
   /**
	* @var string
	*/
   public $number;
   
	/**
	 * {@inheritDoc}
	 */
   public static function fromJson($json)
   {
		$phone = new Phone();
		$phone->type = $json->type;
		$phone->number = $json->number;
		
		return $phone;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function validate()
	{
		if ($this->getNumber() === null) {
			throw new \Exception('shopper.phone.number cannot be null or empty.');
		}
	}

   /** 
	* Get the value of type
	* 
	* @return string
	*/
   public function getType()
   {
	   return $this->type;
   }

   /** 
	* Get the value of number
	* 
	* @return string 
	*/
   public function getNumber()
   {
	   return $this->number;
   }
} 