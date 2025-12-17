<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Queue_model extends CI_Model {

    private $table = 'tbl_api_queue';
    const MAX_WORKER_ATTEMPTS = 3; // Max attempts before marking job as permanently 'Failed'

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Inserts a new job into the queue (called by the public controller).
     * @param string $api_type The type of API call (e.g., 'PI1')
     * @param string $payload The JSON string containing the data
     * @return int The ID of the newly inserted job, or FALSE on failure.
     */
    public function insert_job($api_type, $payload) {
        $data = [
            'api_type'   => $api_type,
            'payload'    => $payload,
            'status'     => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Fetches a batch of pending jobs for the CLI worker.
     * Marks them as 'Processing' to prevent other workers from taking them.
     * @param int $limit The maximum number of jobs to fetch.
     * @return array|null An array of job objects, or null if empty.
     */
    public function get_pending_batch($limit = 5000) {
        
        // 1. Select the batch of 'Pending' jobs
        $this->db->select('id, api_type, payload, attempts');
        $this->db->where('status', 'Pending');
        $this->db->where('attempts <', self::MAX_WORKER_ATTEMPTS); // Only get jobs eligible for retry
        $this->db->order_by('created_at', 'ASC'); // FIFO (First-In, First-Out)
        $this->db->limit($limit);
        $query = $this->db->get($this->table);

        $jobs = $query->result();

        if (!empty($jobs)) {
            // 2. Extract IDs for batch update
            $job_ids = array_column($jobs, 'id');
            
            // 3. Mark the retrieved jobs as 'Processing'
            $this->db->where_in('id', $job_ids);
            $this->db->set('status', 'Processing');
            $this->db->update($this->table);
        }

        return $jobs;
    }

    /**
     * Updates the job status after execution by the worker.
     * @param int $job_id The ID of the job being processed.
     * @param string $new_status 'Success' or 'Failed' (or 'Pending' for retry).
     * @param string $log The response or error message.
     * @return bool
     */
    public function update_status($job_id, $new_status, $log) {
    // Force $log to be a string if it is an array or object
    if (is_array($log) || is_object($log)) {
        $log = json_encode($log);
    }

    $update_data = [
        'response_log' => $log,
        'processed_at' => date('Y-m-d H:i:s'),
        'status'       => $new_status
    ];

    $this->db->where('id', $job_id);
    return $this->db->update('tbl_api_queue', $update_data);
}
}