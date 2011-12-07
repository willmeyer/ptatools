<?php

function deviceIsProvisioned() {
	if (isset($_COOKIE["asfs"]) && ($_COOKIE["asfs"] == "provisioned")) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function getDfltArg($name, $dflt) {
	if (isset($_GET[$name])) $val = $_GET[$name];
	else if (isset($_POST[$name])) $val = $_POST[$name];
	else {
		return $dflt;
	}
	if (($val == "1") || ($val == "true") || ($val == "yes")) return true;	
	if (($val == "0") || ($val == "false") || ($val == "no")) return false;
	return $val;	
}

// TODO throw an exception or something
function getRequiredArg($name) {
	$val = getDfltArg($name, NULL);
	if ($val == NULL) {
		// TODO
	} else {
		return $val;
	}
}

function tstamptotime($tstamp) {
	// converts ISODATE to unix date
	// 1984-09-01T14:21:31Z
	sscanf($tstamp,"%u-%u-%uT%u:%u:%uZ",$year,$month,$day,$hour,$min,$sec);
	$newtstamp=mktime($hour,$min,$sec,$month,$day,$year);
	return $newtstamp;
}

function dbglog($msg) {
	if (defined("DBGLOG_ENABLED") && DBGLOG_ENABLED) {
		$trace = debug_backtrace();
		//var_dump($trace);
		$file = $trace[0]["file"];
		$line = $trace[0]["line"];
		if (strrpos($file, "/") > 0) {
			$file = substr($file, strrpos($file, "/") + 1);
		} 
		$logLine = "[" . $file . ":" . $line . "] " . $msg;
		echo $logLine . "<br/>\n";
		flush();
	}
}

function httpResp($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$resp = curl_exec($ch);
	if(curl_errno($ch)) {
		echo "Curl error loading " . $url . ": " . curl_error($ch) . "<br/>";
		curl_close($ch);
		return null;
	}
	curl_close($ch);
	return $resp;
}

function httpPost($url, $fields) {
	foreach($fields as $key=>$value) { 
		$fieldStr  .= $key.'='.$value.'&'; 
	} 
	rtrim($fieldStr,'&');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fieldStr);
	$resp = curl_exec($ch);
	if(curl_errno($ch)) {
		echo "Curl error loading " . $url . ": " . curl_error($ch) . "<br/>";
		curl_close($ch);
		return null;
	}
	curl_close($ch);
	return $resp;
}

function urlParamsToKv($str) {
	$pairs = array();
	$strs = explode("&", $str);
	foreach($strs as $str) {
		//echo $str . "<br/>";
		$thisPair = explode("=", $str);
		$pairs[$thisPair[0]] = $thisPair[1];
	} 
	return $pairs;
}

?>