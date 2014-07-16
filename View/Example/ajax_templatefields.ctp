<?php
//Check variables
if( empty($template['variables'][1]) ){
	//No variables
	echo __('This template has no variables to fill in');
}else{

	//Loop through vars
	foreach($template['variables'][1] as $name){
		//Display form field
		echo $this->Form->input("Variables.$name",array());
	}

}

//Print button
echo $this->Form->button(__('Print'),array('type'=>'submit','class'=>'btn btn-success'));
?>