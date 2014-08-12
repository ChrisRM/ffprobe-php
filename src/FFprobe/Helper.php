<?php namespace Codecandy\FFprobe;

class Helper {

	public static function durationToTime($duration)
	{
		$t = round($duration);
  		return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
	}
	
}