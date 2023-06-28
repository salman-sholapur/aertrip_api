<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonM extends CI_Model {

    
    function getContactById($contact_id)
    {
        $this->db->where(array('contact_id' => $contact_id)); 
        $this->db->limit(1);
        $query = $this->db->get('employee_contact'); 
        if($query->num_rows()){   
            return $query->row_array();
        }
        return FALSE;
    }
    
    function getEmployeeById($employee_id)
    {
        $this->db->where(array('employee_id' => $employee_id)); 
        $this->db->limit(1);
        $query = $this->db->get('employee'); 
        if($query->num_rows()){   
            return $query->row_array();
        }
        return FALSE;
    }

    function getEmployeeByDepartmentId($department_id)
    {
        $this->db->where(array('department_id' => $department_id));  
        $query = $this->db->get('emp_works_dept');  
        return $query->num_rows();
    }

    function getCompanyById($companyId)
    {
        $this->db->where(array('company_id' => $companyId));  
        $this->db->limit(1);
        $query = $this->db->get('company'); 
        if($query->num_rows()){   
            return $query->row_array();
        }
        return FALSE;
    }

    function getDepartmentById($departmentId)
    {
        $this->db->where(array('department_id' => $departmentId)); 
        $this->db->limit(1);
        $query = $this->db->get('department'); 
        if($query->num_rows()){   
            return $query->row_array();
        }
        return FALSE;
    }

    
     
}
