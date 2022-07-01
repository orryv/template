<?php
	
	if(DEV_MODE){
		
		function pp(array|string|object $output) :void
		{
			echo '<pre>';
			print_r($output);
			echo '</pre>';
		}



	}



?>