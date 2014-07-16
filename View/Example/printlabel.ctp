<h1><?php echo __('Print label')?></h1>

<?php
//Create form
echo $this->Form->create('Printlabel');

	//Create fields
	echo $this->Form->input('template_id',array('options'=>$template_list,'empty'=>__('Select template')));
	?>

	<!-- Container div for ajax call -->
	<div id="templatefields_container"></div>

	<?php
	//Actual print button is on view inserted by ajax call

//Close form
echo $this->Form ->end();


//Listener for change of template field:
$this->Js->get('#PrintlabelTemplateId')->event('change',
	$this->Js->request(
        array('action' => 'ajax_templatefields'),
        array(
        	'method'=> 'post',
        	'async' => true, 
        	'update' => '#templatefields_container',
        	'dataExpression'=>true,
        	'data' => $this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
        	)
    )
);
?>