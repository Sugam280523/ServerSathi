<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Extends CI_Controller or CI_Model if you prefer the model to be the entry point
class Worker extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if running from CLI
       // if ( ! $this->input->is_cli_request()) {
         //   exit('No direct script access allowed');
       // }
        $this->load->library('api_handler');
    }

    // This method will be executed by the Cron Job
    public function process_batch() {
        // --- Configuration for Rate/Time Limiting ---
        $batch_size = 5000; // Process up to 5000 jobs per Cron run
        $max_run_time = 55; // Stop after 55 seconds (to avoid 60-second Cron overlap)
        $rate_limit_us = 2000; // 2 milliseconds (2000 microseconds) = 500 calls/sec (1/500 * 1,000,000)
        
        $start_time = microtime(true);
        $jobs = $this->Queue_model->get_pending_batch($batch_size); // Fetches 'Pending' jobs
        
        if (empty($jobs)) {
            log_message('info', 'Worker: No jobs pending.');
            return;
        }

       foreach ($jobs as $job) {
                $url = $this->api_handler->determine_url($job->api_type);
                $result = $this->api_handler->execute_curl($url, $job->payload);

                // 1. Decode the actual response from the external server
                $apiResponseData = json_decode($result['response'], true);

                // 2. Prepare the NESTED format with the real data
                $formattedOutput = [
                    "statusCode" => $result['http_code'],
                    "status"     => ($result['http_code'] == 200) ? "Success" : "Failure",
                    "message"    => ($result['http_code'] == 200) ? "Lot details fetched and updated successfully" : "API Error",
                    "data"       => [
                        [
                            "statusCode" => $result['http_code'],
                            "status"     => ($result['http_code'] == 200) ? "Success" : "Failure",
                            "message"    => ($result['http_code'] == 200) ? "Lot details fetched and updated successfully" : "Error occurred",
                            // 3. This puts the actual external API response inside your log
                            "external_data" => $apiResponseData 
                        ]
                    ]
                ];

                // Convert to string using JSON_UNESCAPED_UNICODE for Tally compatibility
                $finalLog = json_encode($formattedOutput, JSON_UNESCAPED_UNICODE);

                // 4. Update Database
                if ($result['http_code'] == 200) {
                    $this->Queue_model->update_status($job->id, 'Success', $finalLog);
                } else {
                    $this->Queue_model->update_status($job->id, 'Failed', $finalLog);
                }

                // Rate limit for 500/sec (2ms delay)
                usleep(2000); 
            }
    }
    public function cleanup() {
    // Change 2 to 0 just for a 1-minute test
        $rows = $this->Queue_model->purge_old_records(0); 
    }
}