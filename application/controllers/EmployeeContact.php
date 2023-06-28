<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class EmployeeContact extends REST_Controller {
	public function __construct() 
	{ 
        parent::__construct();	 
        $this->load->model('EmployeeContactM'); 
    }


    public function delete_delete($id=null)
    {
        // Check whether department ID is not empty
        if($id){

        	//Validate company id
	    	$validateContact = $this->CommonM->getContactById($id);
	    	if(!$validateContact){
	    		apiBadRequest(['message'=>'Invalid contact id']);
	    	}
  
            // Delete contact record from database
            $delete = $this->EmployeeContactM->delete($id);
            
            if($delete){
                // Set the response and exit
				apiSuccessResponse("Contact has been deleted successfully."); 
            }else{
                // Set the response and exit 
				apiBadRequest(['message'=>'Something went wrong, please try again.']);
            }
        }else{
			// Set the response and exit
			apiNotFoundResponse(['message'=>'No department found.']);
		}
    } 


    public function get_get($id = 0) {
		// Returns all rows if the id parameter doesn't exist,
		//otherwise single row will be returned
		$employees = $this->EmployeeContactM->getRows($id);
		
		//check if the Department data exists
		if(!empty($employees)){
			// Set the response and exit
			//OK (200) being the HTTP response code
			apiOkResponse($employees);
		}else{
			// Set the response and exit
			//NOT_FOUND (404) being the HTTP response code 
			apiNotFoundResponse(['message'=>'No contacts found.']);
		}
	}

    public function update_put() 
    {    
    	$this->form_validation->set_data($this->put());
    	$this->form_validation->set_rules('contact_id', 'Contact id', 'trim|required|numeric|max_length[11]|greater_than[0]');
    	$this->form_validation->set_rules('employee_id', 'Employee id', 'trim|required|numeric|max_length[11]|greater_than[0]');
    	$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|max_length[20]');
    	$this->form_validation->set_rules('contact_address', 'Contact address', 'trim|required|max_length[255]'); 
    	if($this->form_validation->run())
	    {   
	    	//Validate Eemployee id
	    	$contact_id = $this->put('contact_id');
	    	$validateContact = $this->CommonM->getContactById($contact_id);
	    	if(!$validateContact){
	    		apiBadRequest(['message'=>'Invalid contact id']);
	    	}

	    	//Validate Eemployee id
	    	$employee_id = $this->put('employee_id');
	    	$validateEmployee = $this->CommonM->getEmployeeById($employee_id);
	    	if(!$validateEmployee){
	    		apiBadRequest(['message'=>'Invalid employee id']);
	    	}

	    	//Prepare department array
	    	$saveData = array(
				'employee_id' => $this->put('employee_id'),
				'contact_number' => $this->put('contact_number'),
				'contact_address' => $this->put('contact_address')
			);
 
	    	// Update department record in database
			$update = $this->EmployeeContactM->update($saveData, $contact_id);

			// Check if the department data inserted
			if($update){  
				// Set the response and exit
				apiSuccessResponse("Employee contact has been updated successfully."); 
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
    	$this->form_validation->set_rules('employee_id', 'Employee id', 'trim|required|numeric|max_length[11]|greater_than[0]');
    	$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required|max_length[20]');
    	$this->form_validation->set_rules('contact_address', 'Contact address', 'trim|required|max_length[255]'); 
    	if($this->form_validation->run())
	    {   
	    	//Validate Eemployee id
	    	$validateEmployee = $this->CommonM->getEmployeeById($this->post('employee_id'));
	    	if(!$validateEmployee){
	    		apiBadRequest(['message'=>'Invalid employee id']);
	    	}

	    	//Prepare department array
	    	$saveData = array(
				'employee_id' => $this->post('employee_id'),
				'contact_number' => $this->post('contact_number'),
				'contact_address' => $this->post('contact_address')
			);

	    	// Insert department record in database
			$contact_id = $this->EmployeeContactM->insert($saveData);

			// Check if the department data inserted
			if($contact_id){  
				// Set the response and exit
				apiSuccessResponse("Employee contact has been saved successfully."); 
			}else{
				// Set the response and exit
				apiBadRequest("Something went wrong, please try again."); 
			} 
	    }else{  
	    	apiBadRequest($this->form_validation->error_array());
	    }  
	}
  
}