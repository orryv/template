<?php

	function randstr($length, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $safe = true){
        $o = '';
        $l = strlen($chars)-1;
        for ($i=0; $i < $length; $i++) { 
            $rand = ($safe === true)
                ? random_int(0, $l)
                : rand(0, $l);
            $o.= substr($chars, $rand, 1);
        }
        return $o;
    }


?>