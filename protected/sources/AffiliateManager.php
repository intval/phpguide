<?php

require_once __DIR__.'/Affilosophy.php';

class AffiliateManager {

    private $logger;

    public function __construct(\Psr\Log\LoggerInterface $logger, $affiliatePrivateKey)
    {
        $this->logger = $logger;
        $this->privateKey = $affiliatePrivateKey;
    }

    public function NotifyAffiliatePurchace($sum, $saleid)
    {

            $l_ProgID    = "39C058EC9767EE612615ED224038A4D5";

            $l_Currency  = "ILS";

            $response = ""; // response from affilosophy

            $l_SaleSum =  $sum; //Enter here your sale sum
            $l_SaleID  =  $saleid; //Enter here your unique sale id
                          //or leave empty

        $reported = Affilosophy_Sale_Report_Service($response, Affilosophy_GetClickId($l_ProgID), $l_SaleSum, $l_Currency, $this->privateKey, $l_SaleID);
        $this->logger->info("Reported sale to affiliate program, sum: $sum, saleid: $saleid, report: $reported, response: $response ");

    }
} 