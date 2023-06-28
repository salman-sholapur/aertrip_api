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

    public function delete_delete($id=null)
    {
        // Check whether department ID is not empty
        if($id){

        	//Validate company id
	    	$validateEmployee = $this->CommonM->getEmployeeById($id);
	    	if(!$validateEmployee){
	    		$this->badRequest(['message'=>'Invalid employee id']);
	    	}
  
            // Delete department record from database
            $delete = $this->EmployeeM->delete($id);
            
            if($delete){
                // Set the response and exit
				$this->successResponse("Employee has been deleted successfully."); 
            }else{
                // Set the response and exit 
				$this->badRequest(['message'=>'Something went wrong, please try again.']);
            }
        }else{
			// Set the response and exit
			$this->notFoundResponse(['message'=>'No department found.']);
		}
    } 

    public function get_get($id = 0) {
		// Returns all rows if the id parameter doesn't exist,
		//otherwise single row will be returned
		$employees = $this->EmployeeM->getRows($id);
		
		//check if the Department data exists
		if(!empty($employees)){
			// Set the response and exit
			//OK (200) being the HTTP response code
			$this->response($employees, REST_Controller::HTTP_OK);
		}else{
			// Set the response and exit
			//NOT_FOUND (404) being the HTTP response code 
			$this->notFoundResponse(['message'=>'No employee(s) found.']);
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
	    		$this->badRequest(['message'=>'Invalid employee id']);
	    	}
  

			//Prepare department array
	    	$saveData = array( 
				'emp_name' => $this->put('emp_name'),
				'emp_email_id' => $this->put('emp_email_id'),
				'emp_salary' => $this->put('emp_salary')
			);
			$employee_id = $this->put('employee_id');
	    	// Update department record in database
			$update = $this->EmployeeM->update($saveData, $employee_id);
			// Check if the user data updated
			if($update){

				//Save the employee department
				$departments = $this->put('emp_departments'); 
		    	if($departments && is_array($departments)){
			    	$this->EmployeeM->saveDepartments($departments, $employee_id);	 
			    } 

				// Set the response and exit 
				$this->successResponse("Employee has been updated successfully."); 
			}else{
				// Set the response and exit
				$this->badRequest("Something went wrong, please try again."); 
			}
		}else{  
	    	$this->badRequest($this->form_validation->error_array());
	    }
	}

    public function save_post() 
    {   
    	$this->form_validation->set_rules('emp_name', 'Employee name', 'trim|required|max_length[50]');
    	$this->form_validation->set_rules('emp_email_id', 'Employee email', 'trim|required|valid_email|max_length[120]');
    	$this->form_validation->set_rules('emp_salary', 'Employee salary', 'numeric|greater_than_equal_to[0]|max_length[11]'); 
    	if($this->form_validation->run())
	    {   
	    	//Prepare department array
	    	$saveData = array(
				'emp_name' => $this->post('emp_name'),
				'emp_email_id' => $this->post('emp_email_id'),
				'emp_salary' => $this->post('emp_salary')
			);

	    	// Insert department record in database
			$employee_id = $this->EmployeeM->insert($saveData);

			// Check if the department data inserted
			if($employee_id){

				//Save the employee department
				$departments = $this->post('emp_departments'); 
		    	if($departments && is_array($departments)){
			    	$this->EmployeeM->saveDepartments($departments, $employee_id);	 
			    } 

				// Set the response and exit
				$this->successResponse("Employee has been saved successfully."); 
			}else{
				// Set the response and exit
				$this->badRequest("Something went wrong, please try again."); 
			} 
	    }else{  
	    	$this->badRequest($this->form_validation->error_array());
	    }  
	}
 
	public function badRequest($message)
	{
		return $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
	}

	public function successResponse($message)
	{
		return $this->response(['status' => TRUE, 'message' => $message], REST_Controller::HTTP_OK);
	}

	public function notFoundResponse($message)
	{ 
		return $this->response(['status' => FALSE, 'message' => $message ], REST_Controller::HTTP_NOT_FOUND);
	}

}