<?php namespace Codecandy\FFprobe\Exception;

class FormatNotSupportedException extends Exception
{
	public function __construct($format)
    {
        parent::__construct("Format \"{$format}\" not supported.");
    }
}
