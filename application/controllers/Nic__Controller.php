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
                $this->load->library('api_handler');
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

        $job_id = $this->Queue_model->insert_job($apiType, $finalJson);

       if (!$job_id) {
                throw new Exception("Server Busy: Could not queue request.", 503);
            }

            // 5. IMMEDIATE RESPONSE to Tally
            // Tally receives this in milliseconds, freeing your server to handle the next request
            echo json_encode([
                "statusCode" => 202, 
                "status"     => "Success",
                "message"    => "Job successfully queued for processing.",
                "data"       => [
                    [
                        "statusCode" => 202,
                        "status"     => "Accepted",
                        "queueID"    => $job_id
                    ]
                ]
            ], JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            // Format error using your specific nested JSON structure
            $this->output_error($e->getCode() ? $e->getCode() : 500, "Error", $e->getMessage());
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
          
    
        private function output_error($statusCode, $status, $message)
            {
                $results = [
                    "statusCode" => $statusCode,
                    "status"     => $status,
                    "message"    => $message,
                    "data"       => [
                        [
                            "statusCode" => $statusCode,
                            "status"     => $status,
                            "message"    => $message
                        ]
                    ]
                ];

                header('Content-Type: application/json');
                echo json_encode($results, JSON_UNESCAPED_UNICODE);
                exit; // Stop execution
            }
	
}
