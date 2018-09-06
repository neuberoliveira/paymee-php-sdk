<?php

namespace PayMee\Model;

/**
 * Class BankDetails
 *
 * @package PayMee\Model
 */
class BankDetails
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
		$bank = new BankDetails();
		$bank->branch = $json->branch;
		$bank->account = $json->account;
		
		return $bank;
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
