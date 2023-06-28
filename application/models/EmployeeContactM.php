<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeContactM extends CI_Model {

    public function __construct() {
        parent::__construct();  
        $this->tbl_name = 'employee_contact';
        $this->tbl_emp_dept = 'emp_works_dept';
    }
    

     /*
     * Delete contact data
     */
    public function delete($contact_id)
    { 
        $delete = $this->db->delete($this->tbl_name, array('contact_id' => $contact_id));
 
        return $delete?true:false;
    }

     /*
     * Insert contact data
     */
    public function insert($data = array()) {
        if(!array_key_exists('created_on', $data)){
            $data['created_on'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists('modified_on', $data)){
            $data['modified_on'] = date("Y-m-d H:i:s");
        }
        $insert = $this->db->insert($this->tbl_name, $data);
        if($insert){ 
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

  
    /*
     * Fetch user data
     */
    function getRows($contact_id = "")
    { 
        $this->db->select('ec.contact_id, ec.contact_number, ec.contact_address, e.employee_id, e.emp_name, e.emp_email_id');
        $this->db->from('employee_contact ec');
        $this->db->join('employee e', 'ec.employee_id = e.employee_id');
        if($contact_id){ 
            $this->db->where('ec.contact_id', $contact_id);  
        }
        $query = $this->db->get(); 
        return $query->result_array(); 
    }


    /*
     * Update department data
     */
    public function update($data, $id) {

        if(!empty($data) && !empty($id)){
            if(!array_key_exists('modified_on', $data)){
                $data['modified_on'] = date("Y-m-d H:i:s");
            }
            $update = $this->db->update($this->tbl_name, $data, array('contact_id' => $id)); 
            return $update ? TRUE : FALSE;
        }else{
            return FALSE;
        }
    }


    

}
