<?php
class Home__Model extends CI_Model {
    public function __construct(){
                parent::__construct();
                $this->load->database();
        }
	/*public function DB_Customer_All_Data(){
            $this->db->select('*');
            $this->db->from('tbl_customer_details');
            $this->db->where('Customer_Status', '1');
			$this->db->order_by('Customer_Id', 'asc');
            $query = $this->db->get();
        return $query->result();
    }
	public function DB_Customer_Delete($id,$status){
       
        $this->db->trans_start();
        $this->db->set('Customer_Status',$data);
        $this->db->where('Customer_Id', $id);
        $this->db->update('tbl_customer_details');
        
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
            return false;
        }else{
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return true;
            }
        }
   }
   public function DB_Customer_Add($data){
	   $this->db->insert('tbl_customer_details', $data);
        return $insert_id = $this->db->insert_id();
   }
   public function DB_Customer_Update($data,$ids){
       $this->db->trans_start();
        $this->db->where('Customer_Id', $ids);
       $this->db->update('tbl_customer_details',$data);
        
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
            return false;
        }else{
            if($this->db->affected_rows() > 0){
                return true;
            }else{
                return true;
            }
        }
   }
   public function DB_Customer_Info_Get_IDs($ids){
			$this->db->select('*');
            $this->db->from('tbl_customer_details');
            $this->db->where('Customer_Status', '1');
			$this->db->where('Customer_Id', $ids);
            $query = $this->db->get();
        return $query->result();
   }*/
}
?>