<?php

namespace Core\Error;

class ErrorMessage
{
	private string $type = '';
	private string $message = '';
	private string $file = '';
	private int $line = 0;
	private array $trace = [];

	public function __construct(
		$type,
		$message,
		$file,
		$line,
		$trace = [],
	)
	{
		$this->type = $type;
		$this->message = $message;
		$this->file = $file;
		$this->line = $line;
		$this->trace = $trace;
	}

	public function message()
	{
		$buffer = '';
        if (ob_get_length())
            $buffer = ob_end_clean();

		if(DEV_MODE){

			if(file_exists($this->file)){
				$file = file_get_contents($this->file);
				$file = explode("\r\n", $file);
			}

			$output = '<style>*{margin:0;padding:0;font-family:Verdana;}</style>';
			$output.= '<div style="background-color:red;padding:20px;">';
			$output.= '<b style="font-size:24px;color:white">'.$this->type.'</b>';
			$output.= '<br><br>';
			$output.= '<span>Message: <b>'.$this->message.'</b></span><br>';
			$output.= '<span>File: <b>'.$this->file.'</b>:<b>'.$this->line.'</b></span>';

			$output.= '<br><br><b style="color:white">Code</b><br><br><div style="font-family:monospace">';
			$output.= ($this->line-2).': '.$this->styleSpacesAndTabs(($file[$this->line-3] ?? '')).'<br>';
			$output.= ($this->line-1).': '.$this->styleSpacesAndTabs(($file[$this->line-2] ?? '')).'<br>';
			$output.= '<span style="color:white;font-family:monospace">'.($this->line).': '.$this->styleSpacesAndTabs(($file[$this->line-1] ?? '')).'</span><br>';
			$output.= ($this->line+1).': '.$this->styleSpacesAndTabs(($file[$this->line] ?? '')).'<br>';
			$output.= ($this->line+2).': '.$this->styleSpacesAndTabs(($file[$this->line+1] ?? '')).'<br>';
			$output.= '</div>';
			$output.= '<br><b style="color:white">Stack Trace</b><br><br>';
			if(!empty($this->trace)){
				foreach ($this->trace as $key => $value) {
                	$output.= $value['file'].':'.$value['line'].'<br>';
            	}
            } else if(!empty(debug_backtrace())){
            	foreach (debug_backtrace() as $key => $value) {
            		if(isset($value['file']) && isset($value['line']) && !empty($value['file']) && !empty($value['line']))
            			$output.= $value['file'].':'.$value['line'].'<br>';
            		if(isset($value['class']) && isset($value['function']) && !empty($value['class']) && !empty($value['function']))
            			$output.= ':: '.$value['class'].'::'.$value['function'].'()<br>';
            		$output.= '<br>';
            	}

            }

			$output.= '</div>';


		}
		
		// echo '<pre>';
		// print_r(debug_backtrace());
		// echo '</pre>';

		return $output;


		
	}


	private function styleSpacesAndTabs($str)
	{
		$str = htmlspecialchars($str);
		$str = str_replace(' ', '&nbsp;', $str);
		$str = str_replace('	', '&nbsp;&nbsp;&nbsp;&nbsp;', $str);
		return $str;
	}
}