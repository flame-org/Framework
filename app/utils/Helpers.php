<?php

namespace Flame\Utils;

class Helpers
{
	public static function loader($helper)
	{
		if(method_exists(__CLASS__, $helper)){
			return callback(__CLASS__, $helper);
		}
	}

	public static function nameOfHelper($s)
	{
		#code
	}
}