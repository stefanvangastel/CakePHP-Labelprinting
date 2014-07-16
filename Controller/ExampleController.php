<?php
/**
 * Class ExampleController
 */
class ExampleController extends AppController {

	//Use labelprinter component:
	public $components = array('Labelprinting.Labelprinter');


	public function index(){

		var_dump(Configure::configured('labelprinting'));
		exit;

		die('test');
		//

	}

	/**
	 * Example function to setup and save printer configuration
	 */
	public function setup(){

		//Check request type
		if ( $this->request->is('post') ){

			//Save the form data to the configfile
			if( $this->Labelprinter->saveConfigfile($this->request->data['Labelprinter']) ){

				//Set flash message
				$this->Session->setFlash(__('Printer configuration updated'));
			}else{
				$this->Session->setFlash(__('Error updating printer configuration'));
			}
		}

	}


}