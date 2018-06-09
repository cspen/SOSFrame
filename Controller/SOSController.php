<?php
/**
 * The purpose of the SOSController is to
 * ensure all necessary conditions are met
 * to continue processing the request.
 * 
 * All data necessary must exist. The SOSController
 * should sanitize and validate all incoming data.
 * The SOSController should also validate users for
 * any request operations that require authorized access.
 * 
 * @author Craig Spencer <craigspencer@modintro.com>
 *
 */

class SOSController {
	
	private $model;
	
	public function __construct($model) {
		$this->model = $model;
	}
	
	public function invoke() {
		// Validate user credentials if necessary
		
		// If GET request - process Accept header
		
		
		$this->model->updateState("Update Value");
	}
}



?>