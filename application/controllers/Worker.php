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
        
               // FCPATH points to the root 'Demo' folder where index.php is
                $path = FCPATH . 'application/controllers/nic_controller.php';

                // Log the path to your CI logs so you can see exactly where it is looking
                log_message('debug', "Checking for file at: " . $path);

                if (file_exists($path)) {
                    require_once($path);
                    $this->nic_controller = new Nic_Controller();
                } else {
                    // This will now show you the ACTUAL path in the error message to help us debug
                    show_error("Internal Worker Error: File missing at " . $path);
                }
                $dir = FCPATH . 'application/controllers/';
    $files = scandir($dir);
    echo "<pre>"; print_r($files); echo "</pre>"; die();
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
            
            // Check if we are close to the time limit
            if ((microtime(true) - $start_time) > $max_run_time) {
                log_message('warning', 'Worker: Stopping batch due to time limit.');
                break; // Stop processing and wait for the next Cron run
            }

            // --- 1. Prepare and Execute ---
            $url = $this->nic_controller->determine_url($job->api_type); // Get URL via Nic_Controller method
            
            try {
                // Use the existing, now internal, CURL function
                $response = $this->nic_controller->execute_curl($url, $job->payload);
                
                // --- 2. Success ---
                $this->Queue_model->update_status($job->id, 'Success', $response);
                
            } catch (\Exception $e) {
                // --- 3. Failure ---
                $this->Queue_model->update_status($job->id, 'Failed', $e->getMessage());
            }

            // --- 4. RATE LIMITER ---
            usleep($rate_limit_us); // Pause execution to maintain the 500/sec rate
        }
        log_message('info', 'Worker: Batch completed. Jobs processed: ' . count($jobs));
    }
}