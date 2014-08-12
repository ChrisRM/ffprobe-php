<?php namespace Codecandy\FFprobe;

use Symfony\Component\Process\Process;
use Codecandy\FFprobe\Exception\FormatNotSupportedException;

class FFprobe {

	const STREAMS = 'streams';
	const FRAMES = 'frames';
	const PACKETS = 'packets';
	const FORMAT = 'format';

	/**
	 * Available formats
	 * 
	 * @var array
	 */
	protected $formats = ['json', 'xml'];

	/**
	 * Containing our command
	 * 
	 * @var string
	 */
	protected $command = '';

	/**
	 * Initialize command
	 * 
	 * @param string $file
	 * @param string $command Path to ffprobe if not in /usr/local/bin
	 * @return void
	 */
	public function __construct($file, $command = 'ffprobe')
	{
		$this->command = $command.' -v quiet';

		if (file_exists($file) && is_file($file))
		{
			$this->appendToCommand($file);
		}
	}

	/**
	 * Run and return result of command
	 * 
	 * @return json
	 */
	public function run()
	{
		echo $this->command;
		$process = new Process($this->command);
		$process->run();

		if (!$process->isSuccessful()) {
		    throw new \RuntimeException($process->getErrorOutput());
		}

		return json_decode($process->getOutput());
	}

	/**
	 * Define what information to ask for
	 * 
	 * @param mixed $data
	 * @return $this
	 */
	public function show()
	{
		$data = func_get_args();

		$data = array_map(function($a) {
			return '-show_'.$a;
		}, $data);

		$this->appendToCommand(implode(' ', $data));
	}

	/**
	 * Set output format
	 * 
	 * @param string $format 
	 * @return $this
	 */
	public function setFormat($format)
	{
		if (!in_array($format, $this->formats))
		{
			throw new FormatNotSupportedException($format);
		}

		$this->appendToCommand('-print_format '.$format);

		return $this;
	}

	/**
	 * Make sure the command stays clean
	 * 
	 * @param string $cmd
	 * @return void
	 */
	private function appendToCommand($cmd)
	{
		$this->command = trim($this->command).' '.$cmd;
	}

}