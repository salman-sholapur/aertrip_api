<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DepartmentM extends CI_Model {

    public function __construct() {
        parent::__construct();  
        $this->tbl_name = 'department';
    }


    /*
     * Delete user data
     */
    public function delete($department_id){
        $delete = $this->db->delete($this->tbl_name, array('department_id' => $department_id));
        return $delete?true:false;
    }
 
    /*
     * Fetch user data
     */
    function getRows($id = ""){
        $this->db->select('department_id, dept_name, dept_number, created_on');
        if(!empty($id)){ 
            $this->db->where(array('department_id' => $id));  
            $this->db->limit(1);
            $query = $this->db->get($this->tbl_name);    
            return $query->row_array();  
        }else{ 
            $query = $this->db->get($this->tbl_name);
            return $query->result_array();
        }
    }


    /*
     * Update department data
     */
    public function update($data, $id) {

        if(!empty($data) && !empty($id)){
            if(!array_key_exists('modified_on', $data)){
                $data['modified_on'] = date("Y-m-d H:i:s");
            }
            $update = $this->db->update($this->tbl_name, $data, array('department_id' => $id)); 
            return $update ? TRUE : FALSE;
        }else{
            return FALSE;
        }
    }


    /*
     * Insert department data
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

}
