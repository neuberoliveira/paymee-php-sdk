<?php

namespace PayMee\Helpers;

define("PAYMEE_API_ENDPOINT_SANDBOX", "https://apisandbox.paymee.com.br/v1.1");
define("PAYMEE_API_ENDPOINT", "https://api.paymee.com.br/v1.1");
define("PAYMEE_SDK_VERSION", "0.0.1-snapshot");

use PayMee\Enums\CheckoutType;
use PayMee\Enums\PaymentMethod;
use PayMee\Model\Shopper;
use PayMee\Model\Transaction;
use PayMee\Model\Checkout;
use \Exception;
use \ReflectionException;
/**
 * Class PayMeeCheckout
 *
 * @package PayMee\Helpers
 */
class PayMeeCheckout
{
    /**
     * @var Checkout
     */
    private $checkout;
	
	/**
     * @var string
     */
    private $checkoutType;

    /**
     * @var string
     */
    private $x_api_key;

    /**
     * @var string
     */
    private $x_api_token;

    /**
     * @var bool
     */
    private $is_sandbox;

    /**
     * PayMeeCheckout constructor.
     *
     * @param string $x_api_key
     * @param string $x_api_token
     * @param bool $isSandbox
     */
    public function __construct($x_api_key, $x_api_token, $isSandbox)
    {
        $this->is_sandbox = $isSandbox;
        //Authentication header x-api-key
        $this->x_api_key = $x_api_key;
        //Authentication header x-api-token
		$this->x_api_token = $x_api_token;
		
		$this->checkout = new Checkout();
    }

    /**
     * @param string $currency
     * @return PayMeeCheckout
     */
    public function withCurrency($currency)
    {
        $this->checkout->currency = $currency;
        return $this;
    }

    /**
     * @param float $amount
     * @return PayMeeCheckout
     */
    public function withAmount($amount)
    {
        $this->checkout->amount = $amount;
        return $this;
    }

    /**
     * @param string $referenceCode
     * @return PayMeeCheckout
     */
    public function withReferenceCode($referenceCode)
    {
        $this->checkout->referenceCode = $referenceCode;
        return $this;
    }

    /**
     * @param int $maxAge
     * @return PayMeeCheckout
     */
    public function withMaxAge($maxAge)
    {
        $this->checkout->maxAge = $maxAge;
        return $this;
    }

    /**
     * @param string $paymentMethod
     * @return PayMeeCheckout
     */
	public function withPaymentMethod($paymentMethod)
	{
        $this->checkout->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @param string|null $callbackURL
     * @return PayMeeCheckout
     */
    public function withCallbackURL($callbackURL)
    {
        $this->checkout->callbackURL = $callbackURL;
        return $this;
    }

    /**
     * @param Shopper $shopper
     * @return PayMeeCheckout
     */
    public function withShopper(Shopper $shopper)
    {
        $this->checkout->shopper = $shopper;
        return $this;
    }

    /**
     * @param $checkoutType
     * @param $toJSON
     * @return Transaction|string Transaction object or a json encoded string
     * @throws Exception
     * @throws ReflectionException
     */
    public function create($checkoutType, $toJSON=false)
    {
		$this->checkoutType = $checkoutType;
		
        if (!isset($this->checkoutType)) {
            $this->checkoutType = CheckoutType::SEMI_TRANSPARENT;
        } elseif (isset($this->checkoutType) && !CheckoutType::isValidValue($this->checkoutType)) {
            throw new Exception('checkoutType isnt valid.');
        }
		
        $this->checkout->validate();
        if ($checkoutType === CheckoutType::SEMI_TRANSPARENT) {
			$this->checkout->validadeTransparent();
			return $this->generateTransaction($toJSON);
		}
		
        //Generate gateway redir
        return $this->generateTransaction($toJSON);
    }

    /**
     * @param string $checkoutType
     * @param bool $toJSON
     * @return mixed|string
     * @throws Exception
     */
    private function generateTransaction($toJSON)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $this->generateURL(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($this->checkout),
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "x-api-key: " . $this->x_api_key,
                "x-api-token: " . $this->x_api_token,
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL generateTransaction error: " . $err);
        }
        $response = json_decode($response);
        if ($toJSON === true) {
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }else{
			print_r($response);
			exit('response');
			$response = Transaction::fromJson($response);
			// print_r($response);
		}

        return $response;
	}
	
	protected function generateURL(){
		$base = ($this->is_sandbox) ? PAYMEE_API_ENDPOINT_SANDBOX : PAYMEE_API_ENDPOINT;
		$endpoint = '/checkout';
		
		if ($this->checkoutType === CheckoutType::SEMI_TRANSPARENT) {
			$endpoint = '/checkout/transparent';
		}
		
		return $base.$endpoint;
	}
}

