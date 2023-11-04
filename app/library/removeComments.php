<?php

function removeComments($file){
	$php_0com = file_get_contents($file);
	$php_0com = preg_replace('@/\*.*?\*/|\n\r@s', '', $php_0com);
	return file_put_contents($file, $php_0com);
}
