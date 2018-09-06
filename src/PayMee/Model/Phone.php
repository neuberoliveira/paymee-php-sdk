<?php

namespace PayMee\Model;

/**
 * Class Phone
 *
 * @package PayMee\Model
 */
class Phone
{
	/**
	* @var string
	*/
   public $branch;
   
   /**
	* @var string
	*/
   public $account;
   
   
   public static function fromJson($json){
		$phone = new Phone();
		$phone->type = $json->type;
		$phone->number = $json->number;
		
		return $phone;
	}

   /** 
	* Get the value of branch
	* 
	* @return string
	*/
   public function getBranch(){
	   return $this->branch;
   }

   /** 
	* Get the value of account
	* 
	* @return string 
	*/
   public function getAccount(){
	   return $this->account;
   }
} 