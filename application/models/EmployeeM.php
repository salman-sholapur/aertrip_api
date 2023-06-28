<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeM extends CI_Model {

    public function __construct() {
        parent::__construct();  
        $this->tbl_name = 'employee';
        $this->tbl_emp_dept = 'emp_works_dept';
        $this->tbl_emp_contact = 'employee_contact';
    }
    

    function searchEmployee($keyword)
    {
        $results = array();
        $keyword = urldecode($keyword);
        $this->db->like('emp_name', $keyword); 
        $this->db->or_like('emp_email_id', $keyword);    
        $query = $this->db->get($this->tbl_name);   
        foreach ($query->result_array() as $employee) 
        {  
            //Get department info
            $this->db->select('d.department_id, d.dept_name, d.dept_number');
            $this->db->from('department d');
            $this->db->join('emp_works_dept ed', 'd.department_id = ed.department_id'); 
            $this->db->where('ed.employee_id', $employee['employee_id']);  
            $query = $this->db->get(); 
            $departments = $query->result_array(); 

            //Get contact info 
            $this->db->select('contact_id, contact_number, contact_address');    
            $this->db->where(array('employee_id' => $employee['employee_id'])); 
            $this->db->order_by('contact_id', 'DESC'); 
            $contacts_query = $this->db->get('employee_contact');
            $contacts = $contacts_query->result_array();
            $results[] = array(
                'employee' => $employee,
                'departments' => $departments,
                'contacts' => $contacts
            );
        }
        return $results;
    }


     /*
     * Delete user data
     */
    public function delete($employee_id)
    {
         //Delete employee contacts
        $this->db->delete($this->tbl_emp_contact, array('employee_id' => $employee_id));

        //Delete employee departments
        $this->db->delete($this->tbl_emp_dept, array('employee_id' => $employee_id));

        $delete = $this->db->delete($this->tbl_name, array('employee_id' => $employee_id));
 
        return $delete?true:false;
    }

    public function saveDepartments($departments, $employee_id) 
    {
        //Delete old employee departments
        $this->db->delete($this->tbl_emp_dept, array('employee_id' => $employee_id));

        //Save new employee departments
        if($departments){
            foreach($departments as $department_id)
            { 
                $validDept = $this->CommonM->getDepartmentById($department_id);
                if($validDept){
                    $data = array(
                        'employee_id' => $employee_id,
                        'department_id' => $department_id
                    );
                    $this->db->insert($this->tbl_emp_dept, $data);    
                }
            } 
        } 
    }

    /*
     * Insert employee data
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
    function getRows($id = "")
    {
        $results = array();
        if($id){
            $this->db->where(array('employee_id' => $id));     
        } 
        $this->db->order_by('employee_id', 'ASC'); 
        $query = $this->db->get($this->tbl_name);   
        foreach ($query->result_array() as $employee) 
        {  
            //Get department info
            $this->db->select('d.department_id, d.dept_name, d.dept_number');
            $this->db->from('department d');
            $this->db->join('emp_works_dept ed', 'd.department_id = ed.department_id'); 
            $this->db->where('ed.employee_id', $employee['employee_id']);  
            $query = $this->db->get(); 
            $departments = $query->result_array(); 

            //Get contact info 
            $this->db->select('contact_id, contact_number, contact_address');    
            $this->db->where(array('employee_id' => $employee['employee_id'])); 
            $this->db->order_by('contact_id', 'DESC'); 
            $contacts_query = $this->db->get('employee_contact');
            $contacts = $contacts_query->result_array();
            $results[] = array(
                'employee' => $employee,
                'departments' => $departments,
                'contacts' => $contacts
            );
        }
        return $results;
    }


    /*
     * Update department data
     */
    public function update($data, $id) {

        if(!empty($data) && !empty($id)){
            if(!array_key_exists('modified_on', $data)){
                $data['modified_on'] = date("Y-m-d H:i:s");
            }
            $update = $this->db->update($this->tbl_name, $data, array('employee_id' => $id)); 
            return $update ? TRUE : FALSE;
        }else{
            return FALSE;
        }
    }


    

}
