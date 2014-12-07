<?php

class MyHTMLHelper extends AppHelper {
	
	function fromStringToDate($dateString) {
		if (empty($dateString) || $dateString == '0000-00-00') {
			return false;
		}
		if (is_integer($dateString) || is_numeric($dateString)) {
			$date = intval($dateString);
		} else {
			$date = strtotime($dateString);
		}
		return $date;
	}
	
    function date($dateString = null,$format = "d.m.Y") {
		$date = $this->fromStringToDate($dateString);
		if(! $date){
			return $this->output('-');
		}
		$ret = date($format, $date);
		return $this->output($ret);
	}
}

?>