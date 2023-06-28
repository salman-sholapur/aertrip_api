<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Department extends REST_Controller {
	public function __construct() 
	{ 
        parent::__construct();	 
        $this->load->model('DepartmentM'); 
    }

    public function delete_delete($id=null)
    {
        // Check whether department ID is not empty
        if($id){

        	//Validate company id
	    	$validateDepartment = $this->CommonM->getDepartmentById($id);
	    	if(!$validateDepartment){
	    		$this->badRequest(['message'=>'Invalid department id']);
	    	}


	    	//Validate company id
	    	$isEmployeeExist = $this->CommonM->getEmployeeByDepartmentId($id);
	    	if($isEmployeeExist){
	    		$this->badRequest(['message'=>'Employee(s) exist in this department, So cannot delete this department.']);
	    	}

            // Delete department record from database
            $delete = $this->DepartmentM->delete($id);
            
            if($delete){
                // Set the response and exit
				$this->successResponse("Department has been deleted successfully."); 
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
		$departments = $this->DepartmentM->getRows($id);
		
		//check if the Department data exists
		if(!empty($departments)){
			// Set the response and exit
			//OK (200) being the HTTP response code
			$this->response($departments, REST_Controller::HTTP_OK);
		}else{
			// Set the response and exit
			//NOT_FOUND (404) being the HTTP response code 
			$this->notFoundResponse(['message'=>'No department(s) found.']);
		}
	}

    public function update_put() 
    {   
		$this->form_validation->set_data($this->put());
		$this->form_validation->set_rules('department_id', 'Department id', 'trim|required|numeric|max_length[11]|greater_than[0]');
		$this->form_validation->set_rules('company_id', 'Company id', 'trim|required|numeric|max_length[11]|greater_than[0]');
    	$this->form_validation->set_rules('dept_name', 'Department name', 'trim|required|max_length[50]');
    	$this->form_validation->set_rules('dept_number', 'Department number', 'trim|required|max_length[50]');
    	if($this->form_validation->run())
	    {
	    	//Validate company id
	    	$validateCompany = $this->CommonM->getCompanyById($this->put('company_id'));
	    	if(!$validateCompany){
	    		$this->badRequest(['message'=>'Invalid company id']);
	    	}
 
	    	//Validate company id
	    	$validateDepartment = $this->CommonM->getDepartmentById($this->put('department_id'));
	    	if(!$validateDepartment){
	    		$this->badRequest(['message'=>'Invalid department id']);
	    	}

			//Prepare department array
	    	$saveData = array( 
				'company_id' => $this->put('company_id'),
				'dept_name' => $this->put('dept_name'),
				'dept_number' => $this->put('dept_number')
			);
	    	// Update department record in database
			$update = $this->DepartmentM->update($saveData, $this->put('department_id'));
			// Check if the user data updated
			if($update){
				// Set the response and exit 
				$this->successResponse("Department has been updated successfully."); 
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
		$this->form_validation->set_rules('company_id', 'Company id', 'trim|required|numeric|max_length[11]|greater_than[0]');
    	$this->form_validation->set_rules('dept_name', 'Department name', 'trim|required|max_length[50]');
    	$this->form_validation->set_rules('dept_number', 'Department number', 'trim|required|max_length[50]');
    	if($this->form_validation->run())
	    {  
	    	//Validate company id
	    	$validateCompany = $this->CommonM->getCompanyById($this->post('company_id'));
	    	if(!$validateCompany){
	    		$this->badRequest(['message'=>'Invalid company id']);
	    	}

	    	//Prepare department array
	    	$saveData = array(
				'company_id' => $this->post('company_id'),
				'dept_name' => $this->post('dept_name'),
				'dept_number' => $this->post('dept_number')
			);
	    	// Insert department record in database
			$save = $this->DepartmentM->insert($saveData);

			// Check if the department data inserted
			if($save){
				// Set the response and exit
				$this->successResponse("Department has been added successfully."); 
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