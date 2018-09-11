<?php

namespace PayMee\Model;
use \Exception;

/**
 * Class BankDetails
 *
 * @package PayMee\Model
 */
class BankDetails extends AbstractModel
{
 	/**
	 * @var string
	 */
	public $branch;
	
	/**
	 * @var string
	 */
	public $account;
	
	/**
	 * {@inheritDoc}
	 */
	public static function fromJson($json)
	{
		$bank = new BankDetails();
		$bank->branch = $json->branch;
		$bank->account = $json->account;
		
		return $bank;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function validate()
	{
		if( empty($this->getBranch()) || empty($this->getAccount()) ) {
			throw new \Exception("chosen paymentMethod needs shopper.bankDetais.branch and shopper.bankDetais.account");
			//throw new \Exception("chosen paymentMethod '" . $this->paymentMethod . "' needs shopper.branch and shopper.account");
		}
	}
	
	/** 
	 * Get the value of branch
	 * 
	 * @return string
	 */
	public function getBranch()
	{
		return $this->branch;
	}

	/** 
	 * Get the value of account
	 * 
	 * @return string 
	 */
	public function getAccount()
	{
		return $this->account;
	}
} 
