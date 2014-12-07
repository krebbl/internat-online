<?php 
// simple helper for timing the rendering of elements or other view-sections
// microtime calculations from:
// http://www.chauy.com/2005/11/creating-a-php-script-to-measure-php-execution-time/

class TimerHelper extends AppHelper
{
	var $running_timers = array();
	
	function __construct() {}

	function start($k)
	{
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$this->running_timers[$k] = $time;
	}

	function stop($k)
	{
		$time = microtime();
		$time = explode(" ", $time);
		$time = $time[1] + $time[0];
		$endtime = $time;
		return ($endtime - $this->running_timers[$k]);
	}
}
?>