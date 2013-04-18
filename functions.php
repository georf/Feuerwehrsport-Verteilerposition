<?php


function __autoload($className) {
	require_once(__DIR__.'/classes/'.$className.'.php');
}

// include needed files
require_once(__DIR__.'/config.php');


// try to connect to database
try {
	global $db;

	$db = new Database(
		$config['database']['server'],
		$config['database']['database'],
		$config['database']['username'],
		$config['database']['password']
	);

} catch (Exception $e) {
	echo $e->getMessage();
}



function isPost() {

	$list = func_get_args();

	foreach ($list as $key) {
		if (!isset($_POST[$key])) {
			return false;
		}
	}
	return true;
}


