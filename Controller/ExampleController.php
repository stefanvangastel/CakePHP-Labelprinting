<?php
/**
 * Class ExampleController
 */
class ExampleController extends AppController {

	//Use labelprinter component:
	public $components = array('Labelprinting.Labelprinter');


	public function index(){

		//Redirect to print function
		$this->redirect('printlabel');

	}

	/**
	 * Example function to print a label
	 */
	public function printlabel(){

		//Find templates to use (label templates)
		$templates = $this->Labelprinter->getTemplates();

		//Extract template list:
		$template_list = Hash::combine($templates,'{s}.hash','{s}.name');

		//Check request type
		if ( $this->request->is('post') ){

			//Actual printing

			//Get the template 
			$template = $templates[$this->request->data['Printlabel']['template_id']];

			//Transform template content in a command
			$command = $template['content'];

			//Parse form fields into template / command:
			foreach ($this->request->data['Variables'] as $field => $value) {
				$command = str_replace("<<<$field>>>", $value, $command);
			}

			//Send command to printer:
			if($this->Labelprinter->sendCommand($command)){
				//Set flash message
				$this->Session->setFlash(__('Print command was send'));
			}else{
				//Set flash message
				$this->Session->setFlash(__('Error sending print command: %s',$this->Labelprinter->printerConnectionStatus()));
			}

		}

		//Set view vars:
		$this->set('template_list',$template_list);

		//Render view
	}

	/**
	 * Ajax function to retrieve and display formfields corresponding to placeholders in the template
	 */
	public function ajax_templatefields(){

		//Set ajax layout
		$this->layout = 'ajax';

		//Check variable
		if(! isset($this->request->data['Printlabel']['template_id']) ){
			throw new InternalErrorException(__('Invalid call'));
		}

		//Template id
		$template_id = $this->request->data['Printlabel']['template_id'];

		//Get templates
		$templates = $this->Labelprinter->getTemplates();

		//Check template existance:
		if( ! isset($templates[$template_id])){
			throw new InternalErrorException(__('Template not found'));
		}

		$this->set('template',$templates[$template_id]);
	}

	/**
	 * Ajax function to retrieve and display the printer status
	 */
	public function ajax_printerstatus(){

		//Set printer status
		$this->set('printerstatus',$this->Labelprinter->printerStatus());
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

		//Render view
	}

}