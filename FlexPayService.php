<?php

namespace App\Services;

use GuzzleHttp\Client;

class FlexPayService
{
    const URL_API = 'URL_API';

    const URL_C2B = self::URL_API . '/api/rest/v1/paymentService';
    const URL_B2C = self::URL_API . '/api/rest/v1/merchantPayOutService';
    const URL_CHECK_TRANSACTION = self::URL_API . '/api/rest/v1/check';
    const TOKEN = 'TOKEN_API';
    const MERCHANT = 'MERCHANT';
    const TYPE_OPERATION_MOBILE_MONEY = 1;

    /*
     * Payment consumer to business
     *
     * @param string $phoneNumber
     * @param float $amount
     * @param string $currency
     * @param string $callbackUrl
     * @param float $commission = 0
     */
    public function C2B(string $phoneNumber, float $amount, string $currency, string $callbackUrl, float $commission = 0)
    {
        $result = $this->init(
            self::URL_C2B,
            [
                "merchant" => self::MERCHANT,
                "type" => self::TYPE_OPERATION_MOBILE_MONEY,
                "reference" => $this->getReferenceCode(),
                "phone" => $this->formatPhoneNumber($phoneNumber),
                "amount" => $this->calcAmount($amount, $commission),
                "currency" => $currency,
                "callbackUrl" => $callbackUrl
            ]
        );

        //var_dump($result);
        return $result;
    }

    public function calcAmount(float $amount, float $commission = 0)
    {
        return (($amount * $commission) / 100) + $amount;
    }

    /*
     * Payment business to consumer
     *
     * @param string $phoneNumber
     * @param float $amount
     * @param string $currency
     * @param string $callbackUrl
     * @param float $commission = 0
     */
    public function B2C(string $phoneNumber, float $amount, string $currency, string $callbackUrl, float $commission = 0)
    {
        $result = $this->init(
            self::URL_B2C,
            [
                "merchant" => self::MERCHANT,
                "type" => self::TYPE_OPERATION_MOBILE_MONEY,
                "reference" => $this->getReferenceCode(),
                "phone" => $this->formatPhoneNumber($phoneNumber),
                "amount" => $this->calcAmount($amount, $commission),
                "currency" => $currency,
                "callbackUrl" => $callbackUrl
            ]
        );

        //var_dump($result);
        return $result;
    }

    /*
     * Check transaction
     *
     * @param string $orderNumber
     */
    public function CHECK_TRANSACTION(string $orderNumber)
    {
        $result = $this->init(self::URL_CHECK_TRANSACTION . '/' . $orderNumber, [], 'GET');

        //var_dump($result);
        return $result;
    }

    /*
     * getReference code
     */
    public function getReferenceCode(string $prefix = '')
    {
        return uniqid($prefix);
    }

    /*
     * Format phone number consumer
     *
     * @param string $phoneNumber
     */
    public function formatPhoneNumber(string $phoneNumber)
    {
        // Format the number according to your needs
        return $phoneNumber;
    }

    /*
     * Init flexPlay operation
     *
     * @param string $uri
     * @param Array $body
     * @param string $method
     */
    private function init(string $uri, array $body, string $method = 'POST')
    {
        try {
            $http = new Client();
            $response = $http->request($method, $uri, [
                'headers' => [
                    'Authorization' => self::TOKEN,
                    'Accept'        => 'application/json'
                ],
                'json' => $body
            ]);

            return json_decode($response->getBody());
        }
        catch (\Exception $exception) {
            // operation failed
            // var_dump($exception)
            return false;
        }
    }
}
