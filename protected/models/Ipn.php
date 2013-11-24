<?php

class Ipn
{
    /***
     * @var Helpers $helpers;
     */
    protected $logger, $helpers, $ipnListener;
    private $tempRequestId;

    public function __construct(\Psr\Log\LoggerInterface $logger, Helpers $emailHelper, IpnListener $ipnListener)
    {
        $this->logger = $logger;
        $this->helpers = $emailHelper;
        $this->ipnListener = $ipnListener;
        $this->tempRequestId = rand();
    }

    public function ProcessIpnRequest(array $postData)
    {
        try{
            $this->logger->info($this->tempRequestId.": Attempting to process ipn request with data: " . var_export($postData, true));
            $this->TryProcessIpnRequest($postData);
        }
        catch(\Exception $ex)
        {
            $message = $this->tempRequestId.": Could not process ipn response: \r\n" . $ex->getMessage() . PHP_EOL. PHP_EOL. PHP_EOL . var_export($_REQUEST, true);
            $this->logger->error($message);
            $this->helpers->sendMail([Yii::app()->params['adminEmail']], 'Ipn failure', $message);
            throw $ex;
        }
    }

    private function TryProcessIpnRequest(array $postData)
    {
        $this->ipnListener->requirePostMethod();
        $this->ipnListener->use_sandbox = true;
        $verified = $this->ipnListener->processIpn($postData);

        $this->logger->info($this->tempRequestId.": Ipn request was verified as <".var_export($verified, true).">;");
        $this->helpers->sendMail([Yii::app()->params['adminEmail']], 'Succesful purchace', $this->ipnListener->getTextReport());
    }
} 