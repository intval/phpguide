<?php

class Ipn
{

    const EXPECTED_CURRENCY = 'ILS';

    protected $logger, $helpers, $ipnListener;
    private $tempRequestId, $adminEmail, $paypalReceiverEmail, $user;

    public function __construct(\Psr\Log\LoggerInterface $logger, Helpers $emailHelper, IpnListener $ipnListener, User $currentUser = null, $adminEmail, $paypalReceiverEmail)
    {
        $this->logger = $logger;
        $this->helpers = $emailHelper;
        $this->ipnListener = $ipnListener;

        $this->tempRequestId = rand();
        $this->adminEmail = $adminEmail;
        $this->paypalReceiverEmail = $paypalReceiverEmail;
        $this->user = $currentUser;
    }

    public function ProcessIpnRequest(array $postData, $expectedAmount, $productName, $filePath)
    {
        try{
            $this->logger->info($this->tempRequestId.": Attempting to process ipn request with data: " . var_export($postData, true));
            $this->TryProcessIpnRequest($postData, $expectedAmount, $productName, $filePath);
        }
        catch(\Exception $ex)
        {
            $message = $this->tempRequestId.": Could not process ipn response: \r\n" . $ex->getMessage() . PHP_EOL. PHP_EOL. PHP_EOL . var_export($postData, true);
            $this->logger->error($message);
            $this->helpers->sendMail([$this->adminEmail], 'Ipn failure', $message);
            throw $ex;
        }
    }

    private function TryProcessIpnRequest(array $postData, $expectedAmount, $productName, $filePath)
    {
        $this->ipnListener->requirePostMethod();
        $verified = $this->ipnListener->processIpn($postData);

        $this->logger->info($this->tempRequestId.": Ipn request was verified as <".var_export($verified, true).">;");

        if($verified)
        {
            if($this->checkCompletedRequest($postData, $expectedAmount))
            {
                $this->successfulPurchase($postData, $productName, $filePath, $this->ipnListener->getTextReport());
            }
        }
        else
        {
            throw new \Exception("Could not verify ipn request: ".$this->tempRequestId);
        }
    }

    private function successfulPurchase(array $postData, $productName, $filePath, $textReport){

        $order = new Order();
        $order->ip = Yii::app()->request->getUserHostAddress();
        $order->buyer_email = $postData['payer_email'];
        $order->product = $productName;
        $order->data = var_export($postData, true) . PHP_EOL. PHP_EOL . $textReport;
        $order->time = new SDateTime();
        $order->txid = $postData['txn_id'];

        if(null !== $this->user)
            $order->buyer = $this->user->id;

        $order->save(false);

        $this->helpers->sendMail([$this->adminEmail], 'Succesful ipn', $textReport . PHP_EOL . var_export($postData, true));
        $this->helpers->sendMail([$order->buyer_email], 'הספר שלך: OOP מאפס', 'תודה על הקניה', $filePath);
    }

    private function checkCompletedRequest(array $postData, $expectedAmount){

        if($postData['payment_status'] != 'Completed'){
            return false;
        }

        if($postData['receiver_email'] !== $this->paypalReceiverEmail)
            throw new \Exception("Receiver email not matching");

        if ($postData['mc_currency'] !== self::EXPECTED_CURRENCY)
            throw new \Exception("Received payment not in expected currency");

        if(floatval($postData['mc_gross']) !== floatval($expectedAmount))
            throw new \Exception("Amount does not match. Expected <".floatval($postData['mc_gross']).'>, got <'.floatval($expectedAmount).'>');

        $existingTransaction = Order::model()->findByAttributes(['txid' => 1]);
        if($existingTransaction !== null)
            throw new \Exception("Duplicate transaction id. Db record #".$existingTransaction->id);

        return true;
    }
} 