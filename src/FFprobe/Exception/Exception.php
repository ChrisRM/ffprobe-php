<?php namespace Codecandy\FFprobe\Exception;

class Exception extends \Exception
{
    public function __construct($message)
	{
		parent::__construct("[FFprobe] $message");
	}
}