<?php

namespace PayMee\Helpers;

define("PAYMEE_API_ENDPOINT_SANDBOX", "https://apisandbox.paymee.com.br/v1/checkout/transparent");
define("PAYMEE_API_ENDPOINT", "https://api.paymee.com.br/v1/checkout/transparent");
define("PAYMEE_SDK_VERSION", "0.0.1-snapshot");

use PayMee\Enums\CheckoutType;
use PayMee\Model\Shopper;
use PayMee\Enums\PaymentMethod;

/**
 * Class PayMeeCheckout
 *
 * @package PayMee\Helpers
 */
class PayMeeCheckout
{
    private $config = [];
    private $x_api_key;
    private $x_api_token;
    private $is_sandbox;

    /**
     * PayMeeCheckout constructor.
     *
     * @param $x_api_key
     * @param $x_api_token
     * @param $isSandbox
     */
    public function __construct($x_api_key, $x_api_token, $isSandbox)
    {
        $this->is_sandbox = $isSandbox;
        //Default currency
        $this->config["currency"] = "BRL";
        //Default maxAge - 06 hours in minutes
        $this->config["max_age"] = 360;
        //Authentication header x-api-key
        $this->x_api_key = $x_api_key;
        //Authentication header x-api-token
        $this->x_api_token = $x_api_token;
    }

    /**
     * @param $currency
     * @return $this
     */
    public function withCurrency($currency)
    {
        $this->config["currency"] = $currency;
        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function withAmount($amount)
    {
        $this->config["amount"] = $amount;
        return $this;
    }

    /**
     * @param $referenceCode
     * @return $this
     */
    public function withReferenceCode($referenceCode)
    {
        $this->config["reference_code"] = $referenceCode;
        return $this;
    }

    /**
     * @param $maxAge
     * @return $this
     */
    public function withMaxAge($maxAge)
    {
        $this->config["max_age"] = $maxAge;
        return $this;
    }

    /**
     * @param $paymentMethod
     * @return $this
     */
    public function withPaymentMethod($paymentMethod)
    {
        $this->config["payment_method"] = $paymentMethod;
        return $this;
    }

    /**
     * @param $callbackURL
     * @return $this
     */
    public function withCallbackURL($callbackURL)
    {
        $this->config["callback_url"] = $callbackURL;
        return $this;
    }

    /**
     * @param Shopper $shopper
     * @return $this
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
    public function create($checkoutType, $toJSON)
    {
        if (!isset($checkoutType)) {
            $checkoutType = CheckoutType::SEMI_TRANSPARENT;
        } elseif (isset($checkoutType) && !CheckoutType::isValidValue($checkoutType)) {
            throw new \Exception('checkoutType isnt valid.');
        }

        if (!isset($this->config["amount"]) || (isset($this->config["amount"]) && !is_numeric($this->config["amount"]))) {
            throw new \Exception('amount "' . $this->config["amount"] . '" should be a valid number. ');
        } elseif (!isset($this->config["reference_code"])) {
            throw new \Exception('reference_code cannot be null or empty.');
        } elseif (!isset($this->config["shopper"]) || (isset($this->config["shopper"]) && !is_a($this->config["shopper"],
                    'PayMee\Shopper'))) {
            throw new \Exception('shopper cannot be null or empty.');
        } elseif (isset($this->config["shopper"]) && is_a($this->config["shopper"], 'Shopper')) {
            $shopper = $this->config["shopper"];
            if (!filter_var($shopper->getEmail(), FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('shopper.email isnt a valid email');
            } elseif ($shopper->getMobile() === null) {
                throw new \Exception('shopper.mobile cannot be null or empty.');
            } elseif ($shopper->getFullName() === null) {
                throw new \Exception('shopper.fullName cannot be null or empty.');
            } elseif ($shopper->getCpf() === null) {
                throw new \Exception('shopper.cpf cannot be null or empty.');
            }
        }

        if ($checkoutType === CheckoutType::SEMI_TRANSPARENT) {
            if (!isset($this->config["payment_method"])) {
                throw new \Exception('payment_method is mandatory in transparent mode');
            } elseif (isset($this->config["payment_method"])
                && !PaymentMethod::isValidValue($this->config["payment_method"])) {
                throw new \Exception($this - config["payment_method"] . ' is not valid for payment_method');
            } elseif (($this->config["payment_method"] === PaymentMethod::BB_TRANSFER || $this->config["payment_method"] === PaymentMethod::ITAU_TRANSFER_GENERIC || PaymentMethod::ITAU_TRANSFER_PJ)
                && ($this->config["shopper"]->getAgency() === null || $this->config["shopper"]->getAccount() === null)) {
                throw new \Exception("chosen payment_method '" . $this->config["payment_method"] . "' needs shopper.agency and shopper.account");
            }

            return $this->generateTransaction($checkoutType, $toJSON);
        }

        //Generate gateway redir
        return $this->generateTransaction($checkoutType, $toJSON);
    }

    /**
     * @param $checkoutType
     * @param $toJSON
     * @return mixed|string
     * @throws \Exception
     */
    private function generateTransaction($checkoutType, $toJSON)
    {
        $request = new \stdClass();
        $request->currency = $this->config["currency"];
        $request->amount = $this->config["amount"];
        $request->referenceCode = $this->config["reference_code"];
        $request->maxAge = $this->config["max_age"];
        $request->shopper = $this->config["shopper"];

        if ($checkoutType === CheckoutType::SEMI_TRANSPARENT) {
            $request->bank = $this->config["payment_method"];
        }
        if (isset($this->config["callback_url"])) {
            $request->callbackUrl = $this->config["callback_url"];
        }

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
        }

        return $response;
    }
}

