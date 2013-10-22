<?php

/**
* Leightweight Template System
*/
class LTemplate
{
	/**
	*
	*/
	private $_values = array();
	
	/**
	* Add a Variable to Template
	*/
	public function setVariable($name, $value)
	{
		$this->$name = $value;
	}
	
	/**
	*
	*/
	public function getVariable($name)
	{
		return $this->$name;
	}
	
	/**
	*
	*/
	public function __set($memberName, $value) 
	{
		$this->_values[$memberName] = $value;
	}
	
	/**
	*
	*/
	public function __get($memberName) 
	{
		return $this->_values[$memberName];
	}
 
	/**
	* Render a File
	*/
	public function render($filename)
	{
		if(!is_file($filename))
			echo("Error: Can't find template");
			
		include($filename);
	}

} // End class LTemplate


?>
