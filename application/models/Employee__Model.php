<?php
class Employee__Model extends CI_Model {
    public function __construct(){
                parent::__construct();
                $this->load->database();
        }

    public function DB__Employee__Add($data){
       $this->db->insert('db_tbl__userdetails', $data);
        return $insert_id = $this->db->insert_id();
    }
   public function DB__Employee__Get(){
            $this->db->select('*');
            $this->db->from('db_tbl__userdetails');
            $this->db->order_by('DB_User__CurrentDate', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function getUserNameById($user_id) {
        if (empty($user_id)) {
            return 'NA';
        }
        $this->db->select('DB_UserName');
        $this->db->from('db_tbl__userdetails');
        $this->db->where('DB_UserId', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->DB_UserName;
        } else {
            return 'NA'; // or handle the case when user is not found
        }
    }
    public function DB__Employee__Get__WithId($id){
        $this->db->select('*');
        $this->db->from('db_tbl__userdetails');
        $this->db->where('DB_UserId', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function DB__Employee__WithId__Get($u,$p){
        $this->db->select('*');
        $this->db->from('db_tbl__userdetails');
        $this->db->where('DB_UserEmailId', $u);
        $this->db->where('DB_User__Password', $p);
        $query = $this->db->get();
        return $query->result();
    }
    public function DB__Employee__NameWithUSerInTable__Get($id){
        $this->db->select('DB_UserName');
        $this->db->from('db_tbl__userdetails');
        $this->db->where('DB_UserId', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function DB__Employee__Update($id, $data){
        $this->db->where('DB_UserId', $id);
        return $this->db->update('db_tbl__userdetails', $data);
    }
    public function DB_GetAllPartners() {
    // Get current user's role and ID from session
    $userRole = $this->session->userdata('user_Role');
    $userId   = $this->session->userdata('user_id');

    $this->db->from('db_tbl__userdetails');
    $this->db->where('DB_UserRole', 'Partner');
    $this->db->where('DB_UserStatus', 1);

    // Role-based data access
    if (in_array($userRole, ['Admin', 'SuperAdmin', 'User'])) {
        // Admin, Superadmin, User → full partner list
        $this->db->select('*');
    } else {
        // Otherwise (e.g., Partner) → only own data
        $this->db->select('*');
        $this->db->where('DB_UserId', $userId);
    }

    $query = $this->db->get();
    return $query->result();
}
}
?>