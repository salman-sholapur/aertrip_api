<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Employee extends REST_Controller {
	public function __construct() 
	{ 
        parent::__construct();	 
        $this->load->model('EmployeeM'); 
    }

    public function search_get($keyword=null) {
		 
		if(empty($keyword)){  
			apiBadRequest("Search keyword is required"); 
		}

		$employees = $this->EmployeeM->searchEmployee($keyword);
		//check if the Employee data exists
		if(!empty($employees)){
			// Set the response and exit
			//OK (200) being the HTTP response code 
			apiOkResponse($employees);
		}else{
			// Set the response and exit
			//NOT_FOUND (404) being the HTTP response code 
			apiNotFoundResponse(['message'=>'No employee(s) found.']);
		}
	}

    public function delete_delete($id=null)
    {
        // Check whether Employee ID is not empty
        if($id){

        	//Validate company id
	    	$validateEmployee = $this->CommonM->getEmployeeById($id);
	    	if(!$validateEmployee){
	    		apiBadRequest(['message'=>'Invalid employee id']);
	    	}
  
            // Delete Employee record from database
            $delete = $this->EmployeeM->delete($id);
            
            if($delete){
                // Set the response and exit
				apiSuccessResponse("Employee has been deleted successfully."); 
            }else{
                // Set the response and exit 
				apiBadRequest(['message'=>'Something went wrong, please try again.']);
            }
        }else{
			// Set the response and exit
			apiNotFoundResponse(['message'=>'No Employee found.']);
		}
    } 

    public function get_get($id = 0) {
		// Returns all rows if the id parameter doesn't exist,
		//otherwise single row will be returned
		$employees = $this->EmployeeM->getRows($id);
		
		//check if the Employee data exists
		if(!empty($employees)){
			// Set the response and exit
			//OK (200) being the HTTP response code
			apiOkResponse($employees, REST_Controller::HTTP_OK);
		}else{
			// Set the response and exit
			//NOT_FOUND (404) being the HTTP response code 
			apiNotFoundResponse(['message'=>'No employee(s) found.']);
		}
	}

    public function update_put() 
    {   
		$this->form_validation->set_data($this->put());
		$this->form_validation->set_rules('employee_id', 'Employee id', 'trim|required|numeric|max_length[11]|greater_than[0]');
		$this->form_validation->set_rules('emp_name', 'Employee name', 'trim|required|max_length[50]');
    	$this->form_validation->set_rules('emp_email_id', 'Employee email', 'trim|required|valid_email|max_length[120]');
    	$this->form_validation->set_rules('emp_salary', 'Employee salary', 'numeric|greater_than_equal_to[0]|max_length[11]');
    	if($this->form_validation->run())
	    {
	    	//Validate Eemployee id
	    	$validateEemployee = $this->CommonM->getEmployeeById($this->put('employee_id'));
	    	if(!$validateEemployee){
	    		apiBadRequest(['message'=>'Invalid employee id']);
	    	}
  

			//Prepare Employee array
	    	$saveData = array( 
				'emp_name' => $this->put('emp_name'),
				'emp_email_id' => $this->put('emp_email_id'),
				'emp_salary' => $this->put('emp_salary')
			);
			$employee_id = $this->put('employee_id');
	    	// Update Employee record in database
			$update = $this->EmployeeM->update($saveData, $employee_id);
			// Check if the user data updated
			if($update){

				//Save the employee Employee
				$departments = $this->put('emp_departments'); 
		    	if($departments && is_array($departments)){
			    	$this->EmployeeM->saveDepartments($departments, $employee_id);	 
			    } 

				// Set the response and exit 
				apiSuccessResponse("Employee has been updated successfully."); 
			}else{
				// Set the response and exit
				apiBadRequest("Something went wrong, please try again."); 
			}
		}else{  
	    	apiBadRequest($this->form_validation->error_array());
	    }
	}

    public function save_post() 
    {   
    	$this->form_validation->set_rules('emp_name', 'Employee name', 'trim|required|max_length[50]');
    	$this->form_validation->set_rules('emp_email_id', 'Employee email', 'trim|required|valid_email|max_length[120]');
    	$this->form_validation->set_rules('emp_salary', 'Employee salary', 'numeric|greater_than_equal_to[0]|max_length[11]'); 
    	if($this->form_validation->run())
	    {   
	    	//Prepare Employee array
	    	$saveData = array(
				'emp_name' => $this->post('emp_name'),
				'emp_email_id' => $this->post('emp_email_id'),
				'emp_salary' => $this->post('emp_salary')
			);

	    	// Insert Employee record in database
			$employee_id = $this->EmployeeM->insert($saveData);

			// Check if the Employee data inserted
			if($employee_id){

				//Save the employee department
				$departments = $this->post('emp_departments'); 
		    	if($departments && is_array($departments)){
			    	$this->EmployeeM->saveDepartments($departments, $employee_id);	 
			    } 

				// Set the response and exit
				apiSuccessResponse("Employee has been saved successfully."); 
			}else{
				// Set the response and exit
				apiBadRequest("Something went wrong, please try again."); 
			} 
	    }else{  
	    	apiBadRequest($this->form_validation->error_array());
	    }  
	}
  
}