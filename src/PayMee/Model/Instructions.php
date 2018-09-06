<?php

namespace PayMee\Model;

/**
 * Class Instructions
 *
 * @package PayMee\Model
 */
class Instructions
{
	/**
	 * @var string
	 */
	public $chosen;
	
	/**
	 * @var string
	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $label;
	
	/**
	 * @var string
	 */
	public $beneficiaryBranch;
	
	/**
	 * @var string
	 */
	public $beneficiaryAccount;
	
	/**
	 * @var string
	 */
	public $beneficiaryName;
	
	/**
	 * @var bool
	 */
	public $needIdentification;
	
	/**
	 * @var string
	 */
	public $identification;
	
	/**
	 * @var array
	 */
	public $steps;
	
	/**
	 * @var object
	 */
	public $redirectUrls;
	
	
	public static function fromJson($json){
		$ins = new Instructions();
		$ins->chosen = $json->chosen;
		$ins->name = $json->name;
		$ins->label = $json->label;
		$ins->beneficiaryBranch = $json->beneficiary_branch;
		$ins->beneficiaryAccount = $json->beneficiary_account;
		$ins->beneficiaryName = $json->beneficiary_name;
		$ins->needIdentification = $json->need_identification;
		$ins->identification = $json->identification;
		$ins->steps = $json->steps;
		$ins->redirectUrls = $json->redirect_urls;
		
		return $ins;
	}

	/** 
	 * Set the value of chosen
	 *
	 * @return string 
	 */
	public function getChosen(){
		return $this->chosen;
	}

	/** 
	 * Set the value of name
	 *
	 * @return string 
	 */
	public function getName(){
		return $this->name;
	}

	/** 
	 * Set the value of beneficiaryAccount
	 *
	 * @return string 
	 */
	public function getBeneficiaryAccount(){
		return $this->beneficiaryAccount;
	}

	/** 
	 * Set the value of beneficiaryName
	 *
	 * @return string 
	 */
	public function getBeneficiaryName(){
		return $this->beneficiaryName;
	}

	/** 
	 * Set the value of needIdentification
	 *
	 * @return bool 
	 */
	public function getNeedIdentification(){
		return $this->needIdentification;
	}

	/** 
	 * Set the value of identification
	 *
	 * @return string 
	 */
	public function getIdentification(){
		return $this->identification;
	}

	/** 
	 * Set the value of steps
	 *
	 * @return array 
	 */
	public function getSteps(){
		return $this->steps;
	}

	/** 
	 * Set the value of redirectUrls
	 *
	 * @return array 
	 */
	public function getRedirectUrls(){
		return $this->redirectUrls;
	}
} 
