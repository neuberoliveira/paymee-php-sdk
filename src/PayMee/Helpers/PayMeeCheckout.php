<?php

namespace PayMee\Helpers;

define("PAYMEE_API_ENDPOINT_SANDBOX", "https://apisandbox.paymee.com.br/v1.1/checkout/transparent");
define("PAYMEE_API_ENDPOINT", "https://api.paymee.com.br/v1.1/checkout/transparent");
define("PAYMEE_SDK_VERSION", "0.0.1-snapshot");

use PayMee\Enums\CheckoutType;
use PayMee\Model\Shopper;
use PayMee\Enums\PaymentMethod;
use PayMee\Model\Transaction;

/**
 * Class PayMeeCheckout
 *
 * @package PayMee\Helpers
 */
class PayMeeCheckout
{
    /**
     * @var array
     */
    private $config = [];

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
        //Default currency
        $this->config["currency"] = "BRL";
        //Default maxAge - 06 hours in minutes
        $this->config["maxAge"] = 360;
        //Authentication header x-api-key
        $this->x_api_key = $x_api_key;
        //Authentication header x-api-token
        $this->x_api_token = $x_api_token;
    }

    /**
     * @param string $currency
     * @return PayMeeCheckout
     */
    public function withCurrency($currency)
    {
        $this->config["currency"] = $currency;
        return $this;
    }

    /**
     * @param float $amount
     * @return PayMeeCheckout
     */
    public function withAmount($amount)
    {
        $this->config["amount"] = $amount;
        return $this;
    }

    /**
     * @param string $referenceCode
     * @return PayMeeCheckout
     */
    public function withReferenceCode($referenceCode)
    {
        $this->config["referenceCode"] = $referenceCode;
        return $this;
    }

    /**
     * @param int $maxAge
     * @return PayMeeCheckout
     */
    public function withMaxAge($maxAge)
    {
        $this->config["maxAge"] = $maxAge;
        return $this;
    }

    /**
     * @param string $paymentMethod
     * @return PayMeeCheckout
     */
    public function withPaymentMethod($paymentMethod)
    {
        $this->config["paymentMethod"] = $paymentMethod;
        return $this;
    }

    /**
     * @param string|null $callbackURL
     * @return PayMeeCheckout
     */
    public function withCallbackURL($callbackURL)
    {
        $this->config["callbackURL"] = $callbackURL;
        return $this;
    }

    /**
     * @param Shopper $shopper
     * @return PayMeeCheckout
     */
    public function withShopper(Shopper $shopper)
    {
        $this->config["shopper"] = $shopper;
        return $this;
    }

    /**
     * @param $checkoutType
     * @param $toJSON
     * @return mixed|string
     * @throws \Exception
     * @throws \ReflectionException
     */
    public function create($checkoutType, $toJSON=false)
    {
        if (!isset($checkoutType)) {
            $checkoutType = CheckoutType::SEMI_TRANSPARENT;
        } elseif (isset($checkoutType) && !CheckoutType::isValidValue($checkoutType)) {
            throw new \Exception('checkoutType isnt valid.');
        }

        if (!isset($this->config["amount"]) || (isset($this->config["amount"]) && !is_numeric($this->config["amount"]))) {
            throw new \Exception('amount "' . $this->config["amount"] . '" should be a valid number. ');
        } elseif (!isset($this->config["referenceCode"])) {
            throw new \Exception('referenceCode cannot be null or empty.');
        } elseif (!isset($this->config["shopper"]) || (isset($this->config["shopper"]) && !is_a($this->config["shopper"],
                    'PayMee\Model\Shopper'))) {
            throw new \Exception('shopper cannot be null or empty.');
        } elseif (isset($this->config["shopper"]) && is_a($this->config["shopper"], 'Shopper')) {
            $shopper = $this->config["shopper"];
            if (!filter_var($shopper->getEmail(), FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('shopper.email isnt a valid email');
            } elseif ($shopper->getPhone()->getNumber() === null) {
                throw new \Exception('shopper.phone.number cannot be null or empty.');
            } elseif ($shopper->getDocument()->getNumber() === null) {
                throw new \Exception('shopper.document.number cannot be null or empty.');
            }
        }

        if ($checkoutType === CheckoutType::SEMI_TRANSPARENT) {
            if (!isset($this->config["paymentMethod"])) {
                throw new \Exception('paymentMethod is mandatory in transparent mode');
            } elseif (isset($this->config["paymentMethod"])
                && !PaymentMethod::isValidValue($this->config["paymentMethod"])) {
                throw new \Exception($this->config["paymentMethod"] . ' is not valid for paymentMethod');
            } elseif (($this->config["paymentMethod"] === PaymentMethod::BB_TRANSFER || $this->config["paymentMethod"] === PaymentMethod::ITAU_TRANSFER_GENERIC || PaymentMethod::ITAU_TRANSFER_PJ)
                && ($this->config["shopper"]->getBankDetails()->getBranch() === null || $this->config["shopper"]->getBankDetails()->getAccount() === null)) {
                throw new \Exception("chosen paymentMethod '" . $this->config["paymentMethod"] . "' needs shopper.branch and shopper.account");
            }
			
			return $this->generateTransaction($checkoutType, $toJSON);
        }

        //Generate gateway redir
        return $this->generateTransaction($checkoutType, $toJSON);
    }

    /**
     * @param string $checkoutType
     * @param bool $toJSON
     * @return mixed|string
     * @throws \Exception
     */
    private function generateTransaction($checkoutType, $toJSON)
    {
        $request = new \stdClass();
        $request->currency = $this->config["currency"];
        $request->amount = $this->config["amount"];
        $request->referenceCode = $this->config["referenceCode"];
        $request->maxAge = $this->config["maxAge"];
        $request->shopper = $this->config["shopper"];
		
		if ($checkoutType === CheckoutType::SEMI_TRANSPARENT) {
            $request->paymentMethod = $this->config["paymentMethod"];
        }
        if (isset($this->config["callbackURL"])) {
            $request->callbackUrl = $this->config["callbackURL"];
        }
		
		/* print_r($request);
		exit('request'); */
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => ($this->is_sandbox) ? PAYMEE_API_ENDPOINT_SANDBOX : PAYMEE_API_ENDPOINT,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($request),
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
            throw new \Exception("cURL generateTransaction error: " . $err);
        }
        $response = json_decode($response);
        if ($toJSON === true) {
            return json_encode($response, JSON_UNESCAPED_UNICODE);
        }else{
			print_r($response);
			$response = Transaction::fromJson($response);
			print_r($response);
			exit('response');
		}

        return $response;
	}
}

