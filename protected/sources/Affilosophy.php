<?php

function Affilosophy_Sale_Report_Service(& $a_ServiceMessage,
                                         $a_ClickId,
                                         $a_SaleSum,
                                         $a_CurrencyCode,
                                         $a_ConfCode,
                                         $a_sale_id = "",
                                         $a_AllowDuplicateSaleId = false
)
{
    $l_Host = "www.affilosophy.com";
    $l_Path = "/il/srv/sa_srv_confirm_sale.php";

    $l_ClickId = $a_ClickId;

    $l_Params = "sa_ci=$l_ClickId&sa_sale_sum=$a_SaleSum&sa_currency_code=$a_CurrencyCode&sa_confcode=$a_ConfCode&sa_sale_id=$a_sale_id" . ($a_AllowDuplicateSaleId ? "&sa_dup_ok=true" : "");

    $l_Head = "";
    $l_Body = "";
    if (!Affilosophy_DoHTTPPost($l_Host, $l_Path, $l_Params, $l_Head, $l_Body))
    {
        $a_ServiceMessage = "#U-100-0001-Error calling server: $l_Body#";
    }
    else
    {
        $a_ServiceMessage =  $l_Body;
    }

    return (!(strpos($a_ServiceMessage,"#S-") === false));
}


function Affilosophy_DoHTTPPost($a_Host, $a_Path, $a_Params, & $a_Head, & $a_Body)
{
    // ************************************************************************---
    // Uri Ginsburg.
    //
    // NOTE!: The HTTP Version is 1.0 in order not to deal with transfer-encodings
    //        (chunked messages)
    // ************************************************************************---
    $l_HTMLHead = array();
    $l_HTML = array();

    $l_Header = sprintf("POST %s HTTP/1.0\r\n".
        "Host: %s\r\n".
        "Content-Type: application/x-www-form-urlencoded\r\n" .
        "Content-Length: %u\r\n\r\n" .
        "%s\r\n",
        $a_Path, $a_Host,
        strlen($a_Params),$a_Params);


    if ($l_Sock =
        @fsockopen($a_Host, 80, $l_ErrCode, $l_Err))
    {
        // --------------------------------------------------------------------
        // Performing request
        // --------------------------------------------------------------------

        fputs($l_Sock, $l_Header);

        // --------------------------------------------------------------------
        // Reading the header
        // --------------------------------------------------------------------

        while (!feof($l_Sock))
        {
            $l_tmpChunk = fgets($l_Sock, 4096);
            if ($l_tmpChunk == "\r\n") break;

            $l_HTMLHead[] = $l_tmpChunk;
        }
        $a_Head = implode($l_HTMLHead,"");

        // --------------------------------------------------------------------
        // Reading the header
        // --------------------------------------------------------------------
        if (preg_match('/HTTP\/[0-9]+.[0-9]+ ([0-9]+) (.*)/', $l_HTMLHead[0], $l_Matches))
        {
            if (($l_RC = $l_Matches[1]) >= 300) // HTTP Success and info
            {
                $a_Body = "$l_Matches[1] $l_Matches[2]";
                fclose($l_Sock);
                return false;
            }
        }
        else
        {
            $a_Body = "Unknown Error";
            fclose($l_Sock);
            return false;
        }

        // --------------------------------------------------------------------
        // Reading the body
        // --------------------------------------------------------------------

        while (!feof($l_Sock))
        {
            $l_HTML[] = fgets($l_Sock, 4096);
        }

        $a_Body = implode($l_HTML,"");

        fclose($l_Sock);
        return true;
    }
    else
    {
        $a_Head = "";
        $a_Body = "Can't find server";
        return false;
    }
}

function Affilosophy_GetClickId($a_ProgID)
{
    if (isset($_COOKIE["affilosophy_visitor_$a_ProgID"]))
    {
        $l_my_click_id = $_COOKIE["affilosophy_visitor_$a_ProgID"];
    }
    else if (isset($_SESSION["affilosophy_visitor"]))
    {
        $l_my_click_id = $_SESSION["affilosophy_visitor"];
    }
    else if (isset($_REQUEST["sa_ci"]))
    {
        $l_my_click_id = $_REQUEST["sa_ci"];
    }
    else
    {
        $l_my_click_id = "";
    }

    return $l_my_click_id;
}

function Affilosophy_Offline_Visit_Service(& $a_ServiceMessage,
                                           $a_ClickId,
                                           $a_ConfCode,
                                           $a_Email,
                                           $a_FullName,
                                           $a_InternalId,
                                           $a_Phone1,
                                           $a_Phone2)
{
    // --------------------------------------------------------------------
    // This function is for OFFLINE usesrs ONLY
    // --------------------------------------------------------------------

    $l_Host = "www.affilosophy.com";
    $l_Path = "/il/srv/sa_srv_mark_for_sale.php";

    $l_ClickId = $a_ClickId;

    $l_Params = "sa_ci=$l_ClickId&sa_fullname=$a_FullName&sa_email=$a_Email&sa_confcode=$a_ConfCode&sa_internal_id=$a_InternalId&sa_ph1=$a_Phone1&sa_ph2=$a_Phone2";

    $l_Head = "";
    $l_Body = "";
    if (!Affilosophy_DoHTTPPost($l_Host, $l_Path, $l_Params, $l_Head, $l_Body))
    {
        $a_ServiceMessage = "#U-100-0001-Error calling server: $l_Body#";
    }
    else
    {
        $a_ServiceMessage =  $l_Body;
    }

    return (!(strpos($a_ServiceMessage,"#S-") === false));
}

?>