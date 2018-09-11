<?php

namespace PayMee\Model;
use PayMee\Enums\PaymentMethod;
use \Exception;

/**
 * Class Checkout
 *
 * @package PayMee\Model
 */
class Checkout extends AbstractModel
{
	/**
	 * @var string
	 */
	public $currency = 'BRL';
	
    /**
	 * @var 
	 */
	public $amount;
	
    /**
	 * @var 
	 */
	public $referenceCode;
	
    /**
	 * @var 
	 */
	public $maxAge = 360;
	
    /**
	 * @var 
	 */
	public $paymentMethod;
	
    /**
	 * @var 
	 */
	public $callbackURL;
	
    /**
	 * @var Shopper
	 */
	public $shopper;
	
	/**
	 * {@inheritDoc}
	 */
	public static function fromJson($json)
	{
		$checkout = new Checkout();
		$checkout->currency = $json->currency;
		$checkout->amount = $json->amount;
		$checkout->referenceCode = $json->referenceCode;
		$checkout->maxAge = $json->maxAge;
		$checkout->paymentMethod = $json->paymentMethod;
		$checkout->callbackURL = $json->callbackURL;
		$checkout->shopper = Shopper::fromJson($json->shopper);
		
		return $checkout;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function validate()
	{
		if (!is_numeric($this->amount)) {
            throw new \Exception('amount "' . $this->amount . '" should be a valid number. ');
        } elseif (empty($this->referenceCode)) {
            throw new \Exception('referenceCode cannot be null or empty.');
        } elseif ($this->shopper && !is_a($this->shopper, 'PayMee\Model\Shopper')) {
            throw new \Exception('shopper cannot be null or empty.');
        }
	}
	
	public function validadeTransparent()
	{
		if (empty($this->paymentMethod)) {
			throw new \Exception('paymentMethod is mandatory in transparent mode');
		} elseif (!PaymentMethod::isValidValue($this->paymentMethod)) {
			throw new \Exception($this->paymentMethod . ' is not valid for paymentMethod');
		} elseif ($this->paymentNeedBankDetails()) {
			$this->shopper->getBankDetails()->validate();
		}
	}
	
	protected function paymentNeedBankDetails()
	{
		return ($this->paymentMethod === PaymentMethod::BB_TRANSFER || $this->paymentMethod === PaymentMethod::ITAU_TRANSFER_GENERIC || PaymentMethod::ITAU_TRANSFER_PJ);
	}
} 