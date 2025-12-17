<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_handler {

    // Move your determine_url logic here
    public function determine_url($apiType) {
         // $baseUrl = "demo.seedtrace.nic.in/inv-apis/billing/";
            switch ($apiType) {
                case "PPI":
                    return  "demo.seedtrace.nic.in/inv-apis/billing/getOrderDetailsByBuyerCode";
                case "PCI":
                    return  "demo.seedtrace.nic.in/inv-apis/billing/pullLotDetailsByBuyerCode";
                case "PGI":
                    return  "demo.seedtrace.nic.in/inv-apis/billing/fetchLotDetailsByBuyerCode";
                default:
                    // Fallback case from original code
                    return "demo.seedtrace.nic.in/inv-apis/billing/createSathiOrder";
            }
    }

    // Move your execute_curl logic here
    public function execute_curl($url, $post_fields) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $post_fields,
            CURLOPT_HTTPHEADER     => ["Content-Type: application/json", "Accept: application/json"],
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['response' => $response, 'http_code' => $httpCode];
       
    }
}