<h1><?php echo __('Printer setup')?></h1>

<?php
//Create form
echo $this->Form->create('Labelprinter');

	//Create fields
	foreach(Configure::read('Labelprinting') as $name => $value){
		echo $this->Form->input($name,array('value'=>$value));
	}

	echo $this->Form->button(__('Save'),array('type'=>'submit','class'=>'btn btn-success'));

echo $this->Form ->end();
?>