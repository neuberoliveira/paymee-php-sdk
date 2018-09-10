<?php

namespace PayMee\Model;

/**
 * Class Phone
 *
 * @package PayMee\Model
 */
class Phone
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
   
   
   public static function fromJson($json){
		$phone = new Phone();
		$phone->type = $json->type;
		$phone->number = $json->number;
		
		return $phone;
	}

   /** 
	* Get the value of type
	* 
	* @return string
	*/
   public function getType(){
	   return $this->type;
   }

   /** 
	* Get the value of number
	* 
	* @return string 
	*/
   public function getNumber(){
	   return $this->number;
   }
} 