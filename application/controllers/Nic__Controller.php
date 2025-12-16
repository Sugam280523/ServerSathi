<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nic__Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	 //public $benchmark;
	 public function __construct(){
                parent::__construct();
                // Your own constructor code
                date_default_timezone_set('Asia/Kolkata');
                header('Content-Type: application/json; charset=utf-8');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
                header("Access-Control-Allow-Headers: Content-Type, Authorization");
                if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                    exit(0);
                }
        }
        public function index(){
	    
    	  try {
        // Attempt to reconnect once at the start to ensure a fresh connection for the entire request
        $this->db->reconnect();

        // 1. Fetch serial key data
        $toVerifySerial = $this->Nic__CURD->DB_Api_Verify_Serial_Key(
            $this->uri->segment(3), // SerialKey
            $this->uri->segment(4)  // LicNo
        );

        // Check if serial key verification failed or returned no data
        if (empty($toVerifySerial) || !isset($toVerifySerial[0])) {
            throw new Exception("Authorization Failed! Invalid Parameter ..System Error..!", 404);
        }

        // --- REMOVED: AMC/Demo Status and Expiry Check (Step 1 end) ---

        // --- REMOVED: Secondary Key Verification (Step 2) ---
        // $custNo   = $toVerifySerial[0]->DB_Cust__Id;
        // $DBApiKey = $toVerifySerial[0]->DBApiKey;
        // ... DB_Api_Verify_Key logic removed ...

        // --- REMOVED: Log API Call Details (Step 3) ---
        // $data_to_Stored = [...]
        // if (!$this->Nic__CURD->DB_Api_DataToDB($data_to_Stored)) { ... }


        // --- 4. Process Input Data for Upstream API ---
        $jsonInput = $this->input->get('_dataToJson');
        $apiKey    = $toVerifySerial[0]->DB_ApiKey;
        $jsonInput = (string)$jsonInput;
        $apiType   = $this->uri->segment(5);

        // Data cleaning operations (assuming clean_json_input is a private helper function)
        $jsonInput = $this->clean_json_input($jsonInput);

        // Attempt to decode the JSON input
        $dataArray = json_decode($jsonInput, TRUE, 512, JSON_INVALID_UTF8_IGNORE);

        if ($dataArray === null && json_last_error() !== JSON_ERROR_NONE) {
            $error_code = json_last_error();
            $error_msg  = json_last_error_msg();
            throw new Exception("JSON Decode Failed (Code: $error_code): $error_msg. Final Input check: " . substr($jsonInput, 0, 100) . "...", 400);
        }

        // Merge API Key into the payload
        $newPayload = array_merge(["apiKey" => $apiKey], $dataArray);
        $finalJson = json_encode($newPayload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // --- 5. Determine Upstream URL (assuming determine_url is a private helper function) ---
        $url_Data = $this->determine_url($apiType);

        if (empty($url_Data)) {
            throw new Exception("Url Data incomplete.. Please Try Again...!", 404);
        }

        $job_id = $this->Queue_model->insert_job($apiType, $finalJson);

       echo json_encode([
            "statusCode" => "202", // HTTP 202 Accepted
            "Status"     => "Accepted",
            "Message"    => "Job successfully queued for processing.",
            "QueueID"    => $job_id
        ]);
        // Stop execution to send the fast response
        return;
        // --- 8. Specific Response Manipulation for "SCI" API Type ---
        // (assuming handle_sci_response is a private helper function)
       // if ($apiType == "SCI") {
        ///    $decodedResponse = $this->handle_sci_response($decodedResponse);
        //}

        // Success: Echo the final JSON response from the upstream API
        //echo json_encode($decodedResponse, JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        // Catch all exceptions and format the final error response
        // (assuming output_error is a private helper function)
        $this->output_error($e->getCode(), "Error", $e->getMessage());
    }
    }
    private function clean_json_input($jsonInput)
        {
            $jsonInput = urldecode($jsonInput);
            if (substr($jsonInput, 0, 1) === '"' && substr($jsonInput, -1) === '"') {
                $jsonInput = substr($jsonInput, 1, -1);
            }
            $jsonInput = stripslashes($jsonInput);
            $jsonInput = preg_replace('/[[:^print:]]/', '', $jsonInput);
            $jsonInput = str_replace("'", '"', $jsonInput);
            $jsonInput = trim($jsonInput);
        
            // Remove trailing RESPONCE:
            $pos = strpos($jsonInput, 'RESPONCE:');
            if ($pos !== false) {
                $jsonInput = trim(substr($jsonInput, 0, $pos));
            }
            return $jsonInput;
        }
        private function determine_url($apiType)
        {
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
        
        private function handle_sci_response(array $decodedResponse){
  
                    // Check if the main data key exists
                if (isset($decodedResponse['data'])) {
                    
                    $statusFields = [
                        "statusCode" => $decodedResponse["statusCode"] ?? "",
                        "status"     => $decodedResponse["status"] ?? "",
                        "message"    => $this->normalizeMessage($decodedResponse["message"] ?? "Message Is Empty")
                    ];
            
                    // Case 1: 'data' is an array with at least one element (Your original logic)
                    if (is_array($decodedResponse['data']) && isset($decodedResponse['data'][0])) {
                        // Merge status fields into the first data item
                        $decodedResponse['data'][0] = array_merge($statusFields, $decodedResponse['data'][0]);
                        
                    // Case 2: 'data' is an object (or non-empty associative array) 
                    } elseif (is_array($decodedResponse['data']) && !empty($decodedResponse['data']) && !isset($decodedResponse['data'][0])) {
                        // Merge status fields into the 'data' object itself
                        // This handles your example response structure
                        $decodedResponse['data'] = array_merge($statusFields, $decodedResponse['data']);
            
                    // Case 3: 'data' is an empty array or an empty object.
                    } elseif (is_array($decodedResponse['data']) && empty($decodedResponse['data'])) {
                        // If data array is empty, create a new data item with status/error info
                        $decRespError = $decodedResponse["error"] ?? "";
                        $statusFields["status"] = $statusFields["status"] ?: $decRespError; // Use error if status is empty
                        $decodedResponse['data'][] = $statusFields;
                    
                    // Case 4: 'data' is present but is not an array (e.g., null, string, number - handle defensively)
                    // If you only expect arrays or objects, you might want to log this as an error.
                    } else {
                         // If 'data' is present but doesn't fit the expected structure,
                         // you could wrap it or just return the original response.
                    }
                }
    
                return $decodedResponse;
            }
	private function normalizeMessage($msg) {
        if (empty($msg)) {
            return "Message Is Empty";
        }

        // If message is array → convert to string
        if (is_array($msg)) {
            return implode(", ", $msg);
        }

        // If message is string
        return $msg;
    }
    
    private function execute_curl($url, $post_fields)
        {
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
        private function output_error($statusCode, $status, $message)
        {
            $results = [
                "statusCodec" => $statusCode,
                "Status"      => $status,
                "Message"     => $message,
                "Data"        => ''
            ];
        
            // Assuming you are in a CodeIgniter environment, set the appropriate status header
            // http_response_code($statusCode); // Uncomment if using PHP 5.4+ and not relying on CI output class
        
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
        }
	
}
