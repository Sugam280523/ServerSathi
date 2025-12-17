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
                        CURLOPT_POSTFIELDS     => $post_fields,
                        CURLOPT_HTTPHEADER     => ["Content-Type: application/json", "Accept: application/json"],
                        CURLOPT_CONNECTTIMEOUT => 5,
                        CURLOPT_TIMEOUT        => 20,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_MAXREDIRS      => 3,
                        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                        CURLOPT_FORBID_REUSE   => true,
                    ]);
                
                    $attempt = 0;
                    $maxAttempts = 2;
                    $response = false;
                    $curlErr = '';
                
                    while ($attempt < $maxAttempts) {
                        $attempt++;
                        $response = curl_exec($ch);
                
                        if ($response === false) {
                            $curlErr = curl_error($ch) . ' | errno:' . curl_errno($ch);
                            log_message('error', "[TALLY_API][cURL][attempt $attempt] ERROR: $curlErr");
                            // Small delay before retry (only if not last attempt)
                            if ($attempt < $maxAttempts) { sleep(1); }
                            continue;
                        }
                        // Success on this attempt
                        break;
                    }
                
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                
                    if ($response === false) {
                        log_message('error', "[TALLY_API] Upstream failed after $attempt attempts | HTTP: $httpCode | URI: ".$this->uri->uri_string());
                        throw new Exception("Upstream request failed: $curlErr", 502);
                    }
        
            return $response;
    }
}