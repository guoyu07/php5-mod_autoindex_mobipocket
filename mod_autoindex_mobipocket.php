#!/usr/bin/php
<?php
/**
 * mod_autoindex_mobipocket.php
 * 
 * (c)2013 mrdragonraaar.com
 */
include_once('mobipocket/mobipocket.php');

$autoindex_mobipocket = new AutoIndexMOBIPocket();
echo $autoindex_mobipocket->output();

/**
 * AutoIndex MOBIPocket.
 */
class AutoIndexMOBIPocket
{
	public $directory;
	public $text;

	/**
         * Create new AutoIndexMOBIPocket instance.
         */
	function __construct()
	{
		$this->_init();
	}

	/**
         * Initialise AutoIndexMOBIPocket instance.
         */
	private function _init()
	{
		$this->directory = getenv('SCRIPT_FILENAME');
		$this->text = file_get_contents('php://stdin');
	}

	/**
         * Get MOBIPocket filtered autoindex text.
         * @return autoindex text.
         */
	public function output()
	{
		if (!is_dir($this->directory))
			return $this->text;

		$output = $this->text;

		$offset = 0;
		while (preg_match(AutoIndexMOBIPocket_File::PATTERN_FILENAME, 
		   $this->text, $entry, PREG_OFFSET_CAPTURE, $offset))
		{
			$file_entry = 
			   new AutoIndexMOBIPocket_File($entry[0][0]);

			$output = str_replace($file_entry->text, 
			   $file_entry->output(), $output);

			$offset = $entry[0][1] + 1;
		}

		return $output;
	}
}

/**
 * AutoIndex MOBIPocket File.
 */
class AutoIndexMOBIPocket_File
{
	public $text;
	private $parent;
	private $filename;

	/* Match pattern : filename */
	const PATTERN_FILENAME = '/^<tr>.+<a href="(.+\.mobi)".+<\/tr>/m';
	/* Template : icon */
	const TEMPLATE_REPLACEICON = 'templates/template_icon.php';
	/* Template : filename */
	const TEMPLATE_REPLACEFILENAME = 'templates/template_filename.php';
	/* Replace pattern : icon table cell */
	const PATTERN_REPLACEICON = '/(^<tr><td.+?>).+?(<\/td>.+)/';
	/* Replace pattern : filename table cell */
	const PATTERN_REPLACEFILENAME = '/(^<tr>.+<td>).+?(<\/td>.+)/';

	/**
         * Create new AutoIndexMOBIPocket_File instance.
         * @param $text AutoIndexMOBIPocket_File text.
         */
	function __construct($text)
	{
		$this->_init($text);
	}

	/**
         * Initialise AutoIndexMOBIPocket_File instance.
         * @param $text AutoIndexMOBIPocket_File text.
         */
	private function _init($text)
	{
		$this->parent = getenv('SCRIPT_FILENAME');
		$this->text = $text;
		if (preg_match(self::PATTERN_FILENAME, $text, $filename))
			$this->filename = $filename[1];
	}

	/**
         * Get url encoded filename.
         * @return url encoded filename.
         */
	public function filename_url()
	{
		return $this->filename;
	}

	/**
         * Get filename.
         * @return filename.
         */
	public function filename()
	{
		return $this->filename ? 
		   htmlspecialchars_decode(rawurldecode($this->filename)) : '';
	}

	/**
         * Get fullpath.
         * @return fullpath.
         */
	public function fullpath()
	{
		return $this->filename() ? 
		   ($this->parent . $this->filename()) : '';
	}

	/**
         * Get MOBIPocket filtered file text.
         * @return file text.
         */
	public function output()
	{
		$output = $this->text;

		$mobipocket = new mobipocket();
		if ($mobipocket->open($this->fullpath()))
		{
			$output = $this->replace_icon($output, 
			   $mobipocket);
			$output = $this->replace_filename($output, 
			   $mobipocket);

			$mobipocket->close();
		}

		return $output;
	}

	/**
         * Replace icon text.
         * @param $output file text.
         * @param $mobipocket MOBIPocket.
         * @return file text.
         */
	private function replace_icon($output, $mobipocket)
	{
		return $this->replace_text(self::PATTERN_REPLACEICON,
		   self::TEMPLATE_REPLACEICON, $output, $mobipocket);
	}

	/**
         * Replace filename text.
         * @param $output file text.
         * @param $mobipocket MOBIPocket.
         * @return file text.
         */
	private function replace_filename($output, $mobipocket)
	{
		return $this->replace_text(self::PATTERN_REPLACEFILENAME,
		   self::TEMPLATE_REPLACEFILENAME, $output, $mobipocket);
	}

	/**
         * Replace text using specified pattern with template.
         * @param $pattern replacement pattern.
         * @param $template replacement template.
         * @param $output file text.
         * @param $mobipocket MOBIPocket.
         * @return file text.
         */
	private function replace_text($pattern, $template, $output, $mobipocket)
	{
		if ($replace_text = 
		   $this->replace_text_template($template, $mobipocket))
		{
			$replace_text = str_replace("\n", '', $replace_text);
			$replace_text = str_replace("\r", '', $replace_text);

			$output = preg_replace($pattern, 
			   "$1$replace_text$2", $output);
		}

		return $output;
	}

	/**
         * Get replacement text of specified template.
         * @param $template replacement template.
         * @param $mobipocket MOBIPocket.
         * @return replacement text.
         */
	private function replace_text_template($template, $mobipocket)
	{
		ob_start();
		include($template);
		return ob_get_clean();
	}
}

?>
