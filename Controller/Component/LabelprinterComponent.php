<?php
/**
 * CakePHP-Labelprinting Print Component
 *
 * Copyright 2014, Stefan van Gastel
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, Stefan van Gastel
 * @link          http://stefanvangastel.nl
 * @since         CakePHP-Labelprinting 1.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('PhpReader', 'Configure');


class LabelprinterComponent extends Component {

	/**
	 * Construct function, reads config file
	 */
	public function __construct() {

		//Set config reader
		Configure::config('labelprinting', new PhpReader(CakePlugin::path('Labelprinting').'Config'.DS));

		//Read config file
		Configure::load('config', 'labelprinting');

		//Validate config present
		if( ! Configure::check('Labelprinting') ){
			throw new InternalErrorException(__('Please create a config.php file according to the template in %s',CakePlugin::path('Labelprinting').'Config'));
		}
	}

	/**
	 * Saves configuration file to disk
	 * @param  Array $configfiledata The actual data to save (config array)
	 * @return Bool                 Save action result
	 */
	public function saveConfigfile($configfiledata){

		//Write config data to key
		Configure::write('Labelprinting',$configfiledata);

		//Dump / save the configfile
		return Configure::dump('config.php', 'labelprinting', array('Labelprinting'));
	}


	/**
	 * Returns the printer status
	 * @return String Printer status
	 */
	public function printerStatus(){

		//Create status command: <ESC>!?  (ASCII 27, escape character) 
		$command =  chr(27).'!?';

		//Send command to printer and read 8 bytes:
		$result = $this->sendCommand($command,8);

		if(!$result){
			return $this->printerConnectionStatus();
		}

		//A hex value is returned: Map to this status array:
		$statuscodes = array(
			'00' => 'Normal',
			'01' => 'Head opened',
			'02' => 'Paper Jam',
			'03' => 'Paper Jam and head opened',
			'04' => 'Out of paper',
			'05' => 'Out of paper and head opened',
			'08' => 'Out of ribbon',
			'09' => 'Out of ribbon and head opened',
			'0A' => 'Out of ribbon and paper jam',
			'0B' => 'Out of ribbon, paper jam and head opened',
			'0C' => 'Out of ribbon and out of paper',
			'0D' => 'Out of ribbon, out of paper and head opened',
			'10' => 'Pause',
			'20' => 'Printing',
			'80' => 'Other error'
		);

		//Check statuscode
		if( ! isset($statuscodes[$result]) ){
			return 'Unknown / No connection';
		}

		//Return status
		return $statuscodes[$result];
	}


	public function getTemplates(){

		//Set array
		$templates = array();

		//Fetch all .tspl files in template dir:
		$templatedir = CakePlugin::path('Labelprinting').'Labeltemplates'.DS;

		//Parse templates
		foreach( glob($templatedir.'*.tspl') as $file){

			$template = array();

			//Templatename
			$template['name'] = str_replace('.tspl','',basename($file));
			$template['name'] = Inflector::Humanize($template['name']);

			//Template content:
			$template['content'] = file_get_contents($file);	

			//Find variables in template:
			preg_match_all('/<<<(.*?)>>>/', $template['content'], $matches);

			//Unique:
			$matches[0] = array_unique($matches[0]);
			$matches[1] = array_unique($matches[1]);

			//Set full matches (or false)
			$template['variables'] = $matches;

			//Set hash as value
			$template['hash'] = sha1($template['name']);

			//Add hash of template as key (id)
			$templates[$template['hash']] = $template;
		}

		return $templates;
	}


	/**
	 * Sends a command or multiple commands to the printer
	 * @param  String  $command     String (linebreak separated) of commands
	 * @param  integer $bytestoread Number of bytes to read of result
	 * @return [type]               [description]
	 */
	public function sendCommand($command,$bytestoread = 8192){

		$printeraddr = Configure::read('Labelprinting.printeraddr');
		$printerport = Configure::read('Labelprinting.port');
	
		//Append linebreak (\r) to all commands
		$command .= "\r"; //Use double quotes to interpolate

		//Open socket to printer: TODO: error catching
		$fp = @fsockopen($printeraddr,$printerport,$errno,$errstr,2); //2 second timeout

		//Check connection
		if (!$fp) {
			//Error
			return false;
		} else {
			//Write command
	    	fwrite($fp,$command);

    	}

    	//Return result and make hex of it first
  		$result = bin2hex(fread($fp,$bytestoread)); 

  		//Close connection
  		fclose($fp);

  		//Return result
  		return $result;
	}

	/**
	 * Quick connection check
	 * @return bool/string Connection status
	 */
	public function printerConnectionStatus(){

		//Open socket to printer
		$fp = @fsockopen($printeraddr,$printerport,$errno,$errstr,1); //1 second timeout

		if (!$fp) {
			//Error
			return "ERROR: $errno - $errstr";
		}
		//Close connection
  		fclose($fp);

  		return true;
	}

}