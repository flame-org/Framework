<?php

/**
* Global variables and settings
*/
class OptionsService extends Table
{
	protected $tableName = 'options';

	public function getOptionValue($name)
	{
		$name = $this->findOneBy(array('name' => $name));

		if($name){
			return $name['value'];
		}else{
			return null;
		}
	}

}
?>