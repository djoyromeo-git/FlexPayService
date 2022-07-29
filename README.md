# FlexPayService
FlexPay integration for PHP (https://www.flexpay.cd)

```php
<?php
    // A request is sent to the callback URL to give the status of the transaction
    public function payC2B(FlexPayService $flexPayService) {
      $flexPayService->C2B(
          '243972436105', //phoneNumber
          '100', //amount
          'CDF', //currency
          'www.flexpay.cd', //callbackUrl
          1 //commission
      );
    }

    /*
     * This interface allows a merchant to send electronic money from their account to a phone number
     * that has a mobile money account.
     */
    public function payB2C(FlexPayService $flexPayService) {
      $flexPayService->B2C(
          '243972436105', //phoneNumber
          '100', //amount
          'USD', //currency
          'www.flexpay.cd', //callbackUrl
          1 //commission
      );
    }
    
    // This interface allows you to check the status of a payment request sent to FlexPay
    public function checkTransaction(FlexPayService $flexPayService)(
      $flexPayService->CHECK_TRANSACTION('RVIdaytKD335243972436105');
    }
?>
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)
