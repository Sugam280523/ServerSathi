<?php
class Customer__Model extends CI_Model {
    public function __construct(){
                parent::__construct();
                $this->load->database();
        }

    public function DB__Customer__Add($data){
       $this->db->insert('db_tbl__customerdetails', $data);
        return $insert_id = $this->db->insert_id();
    }
   public function DB__Customer__Get(){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerDemoActivation__Get(){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where_in('DB_Cust__SathiCurrentStatus', ['Lead']);
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__Customer__SerialKey__Check($serialnumber){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SerialKey',$serialnumber);
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerAMCExpired__Get(){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__NextAMCDate <', date('Y-m-d'));
            $this->db->where('DB_Cust__AMCExpired', '0');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerPaymentPending__Get(){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'P');
            $this->db->where_in('DB_Cust__SathiCurrentStatus', ['Live','Demo',]);
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerPaymentRecived__Get(){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'R');
            $this->db->where_in('DB_Cust__SathiCurrentStatus', ['Live']);
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerLive__Get(){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Live');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerDemo__Get(){
            $this->db->select('*');
            $this->db->from('db_tbl__apikeyverifcation T1');
            $this->db->join('db_tbl__customerdetails T2','T1.DB_Cust__Id = T2.DB_Cust__Id','left');
            $this->db->where_in('T2.DB_Cust__SathiCurrentStatus', ['Demo']);
            $this->db->where('T2.DB_Cust__Status !=','0');
            $this->db->order_by('T2.DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();

            
    }
    public function DB__CustomerLead__Get(){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Lead');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__Customer__Get__WithId($id) {
        $this->db->select('c.*, u.DB_UserName AS PartnerName');  // select all customer fields + partner name
        $this->db->from('db_tbl__customerdetails c');
        $this->db->join('db_tbl__userdetails u', 'u.DB_UserId = c.DB_Cust__ParntnerNo', 'left'); // left join for partner name
        $this->db->where('c.DB_Cust__Id', $id);

        $query = $this->db->get();
        return $query->result();
    }
   
    public function DB__ActivationCustomer__Get__WithId($id){
        $this->db->select('
                T1.*, 
                T2.*, 
                T3.DB_UserName AS PartnerName,
                (
                    SELECT COUNT(*) 
                    FROM db_tbl__demoextended DE 
                    WHERE DE.DB_Cust__Id = T2.DB_Cust__Id
                ) AS Total_Demo_Count
            ');

            $this->db->from('db_tbl__apikeyverifcation T1');

            $this->db->join('db_tbl__customerdetails T2', 
                'T1.DB_Cust__Id = T2.DB_Cust__Id', 
                'left'
            );

            // Join to get Partner Name
            $this->db->join('db_tbl__userdetails T3', 
                'T2.DB_Cust__ParntnerNo = T3.DB_UserId',
                'left'
            );

            $this->db->where('T2.DB_Cust__Status !=', '0');
            $this->db->where('T2.DB_Cust__Id', $id);

            $query = $this->db->get();
            return $query->result();
    }
    public function DB__CustomerDemoExtended__Add($data){
        $this->db->insert('db_tbl__demoextended', $data);
        return $this->db->insert_id();
    }
    public function DB__Customer__Update($id,$data){
        $this->db->where('DB_Cust__Id', $id);
        return $this->db->update('db_tbl__customerdetails', $data);
    }
    public function DB__CustomerPaymentPendingDashboard__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'P');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $this->db->limit(10);
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerAMCExpiredDashboard__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__NextAMCDate <', date('Y-m-d'));
            $this->db->where('DB_Cust__AMCExpired', '0');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $this->db->limit(10);
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerPaymentPendingDashboardN__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'P');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerAMCExpiredDashboardN__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__NextAMCDate <', date('Y-m-d'));
            $this->db->where('DB_Cust__AMCExpired', '0');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerLiveDashboard__Get($user_id){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Live');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerDemoDashboard__Get($user_id){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Demo');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerLeadDashboard__Get($user_id){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Lead');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerPaymentRecivedDashboard__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'R');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function DB__CustomerTodayDemoDashboard__Get($user_id){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Demo');
            $this->db->where('DB_Cust__InstalltionDate', date('Y-m-d'));
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerTodayLeadDashboard__Get($user_id){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Lead');
            $this->db->where('DB_Cust__InstalltionDate', date('Y-m-d'));
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerTodayLiveDashboard__Get($user_id){
        $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiCurrentStatus', 'Live');
            $this->db->where('DB_Cust__InstalltionDate', date('Y-m-d'));
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerTodayPaymentPendingDashboard__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'P');
            $this->db->where('DB_Cust__InstalltionDate', date('Y-m-d'));
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }   
    public function DB__CustomerTodayPaymentRecivedDashboard__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SathiPaymentStatus', 'R');
            $this->db->where('DB_Cust__InstalltionDate', date('Y-m-d'));
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerTodayAMCExpiredDashboard__Get($user_id){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__NextAMCDate <', date('Y-m-d'));
            $this->db->where('DB_Cust__AMCExpired', '0');
            $this->db->where('DB_Cust__InstalltionDate', date('Y-m-d'));
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->num_rows();
    }
    public function DB__CustomerAMCExpiredbeforethirtydays__Get($days){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__NextAMCDate >=', date('Y-m-d')); // From today
            $this->db->where('DB_Cust__NextAMCDate <=', date('Y-m-d', strtotime("+$days days"))); // Up to next X days
            $this->db->where('DB_Cust__AMCExpired', '1');
            $this->db->where('DB_Cust__Status !=','0');
            $this->db->order_by('DB_Cust__Id', 'DESC');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerActivation__Get(){
        $this->db->select('*');
        $this->db->from('db_tbl__customerdetails');
        $this->db->where_in('DB_Cust__SathiCurrentStatus', ['Demo']);
        $this->db->where('DB_Cust__Status !=', '0');
        $this->db->order_by('DB_Cust__Id', 'DESC');
        $query = $this->db->get();
        return $query->result();

    }
    public function DB__CustomerActivation__Add($data){
        $this->db->insert('db_tbl__apikeyverifcation', $data);
        return $this->db->insert_id();
    }
    public function DB__Customer__PaymentDetails__Add($data){
        $this->db->insert('db_tbl__paymentdetails', $data);
        return $this->db->insert_id();
    }
    public function DB__ActivationsCustomer__Get(){
            $this->db->select('T1.*,T2.*');
            $this->db->from('db_tbl__apikeyverifcation T1');
            $this->db->join('db_tbl__customerdetails T2','T1.DB_Cust__Id = T2.DB_Cust__Id','left');
            //$this->db->where('T1.DB_ApiKey__Status !=','0');
            $this->db->where('T2.DB_Cust__Status !=','0');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__ActivationsCustomerWithId__Get($id){
        $this->db->select('T1.*,T2.DB_Cust__SerialKey,T2.DB_Cust__Name,T2.DB_Cust__FirmName,T2.DB_Cust__SathiPaymentStatus,T2.DB_Cust__NextAMCDate');
            $this->db->from('db_tbl__apikeyverifcation T1');
            $this->db->join('db_tbl__customerdetails T2','T1.DB_Cust__Id = T2.DB_Cust__Id','left');
            $this->db->where('T1.DB_ApiKey__Status !=','0');
            $this->db->where('T2.DB_Cust__Status !=','0');
            $this->db->where('T1.DB_Cust__Id ',$id);
            $query = $this->db->get();
        return $query->result();
    }
    public function DB__CustomerActivation__Update($id,$data){
        $this->db->where('DB_Cust__Id', $id);
        return $this->db->update('db_tbl__apikeyverifcation', $data);
    }   

}
?>