<?php
class Nic__Model extends CI_Model {
    public function __construct(){
                parent::__construct();
                $this->load->database();
        }
	public function DB_Api_Verify_Key($api_Key,$custNo,$DBApiKey){
	    $toApiKey=$api_Key.$DBApiKey;
	     
            $this->db->select('*');
            $this->db->from('tbl_api_key');
            $this->db->where('Api_Key', $toApiKey);
            $this->db->where('DB_Cust__Id', $custNo);
            $this->db->where('Api_Status', '1');
            $query = $this->db->get();
        return $query->result();
    }
    public function DB_Api_Verify_Serial_Key($serial_Key,$custLicNo){
            $this->db->select('*');
            $this->db->from('db_tbl__customerdetails');
            $this->db->where('DB_Cust__SerialKey',$serial_Key);
            $this->db->where('DB_Cust__LicNo',$custLicNo);
            $query = $this->db->get();
        return $query->result();
    }
    
    public function DB_Api_DataToDB($data){
	   $this->db->insert('DB_Api_DataToDB', $data);
        return $insert_id = $this->db->insert_id();
   }
   public function DB_Timmer($datatimes){
       $data=array(
            "api_inset_Timmer"=>$datatimes,
            "api_process_Timmer"=>'',
            "api_Responed_Timmer"=>''
           );
       $this->db->insert('TimmerChecker', $data);
        return $insert_id = $this->db->insert_id();
   }
   public function DB_Timmer__Updates($date,$id){
       $data=array(
            "api_process_Timmer"=>$date
           );
       $this->db->where('ids', $id);
        return $this->db->update('TimmerChecker', $data);
   }
   public function DB_Timmer__Updates_EndProcess($date,$id){
       $data=array(
            "api_Responed_Timmer"=>$date
           );
       $this->db->where('ids', $id);
        return $this->db->update('TimmerChecker', $data);
   }
}
?>