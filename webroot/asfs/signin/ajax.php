<?php

require_once("config.inc.php");
require_once("utils.inc.php");
require_once("model.inc.php");
require_once("ui.inc.php");

function apiArgRequired($name) {
	$val = getDfltArg($name, NULL);
	if ($val == NULL) {
		respondError("missing parameter '" . $name . "'");
		exit;
	}
	return $val;
}

function apiArgOptional($name, $dfltVal) {
	return getDfltArg($name, NULL);
}

function respondOk($data) {
	echo $data;
}

function respondError($msg, $code = -1) {
	echo 'ERROR: "' . $code . '", "message": "' . $msg . '"}';
}

$action = apiArgRequired("a");

$model = new Model();

if ($action == "getday") {
	$type = apiArgRequired("type");
	$date = apiArgRequired("date");
	$admin = apiArgOptional("admin", false);
	$entries = $model->getEntriesForDate($date, $type);
	$topMessage = null;
	if ($admin) $topMessage = "Entries for " . date("l F jS", strtotime($date));
	$html = renderSignInSheetEntries($entries, false, $admin, $topMessage);
	respondOk($html);
} else if ($action == "getentry") {
	
	// Returns displayable markup for the entry
	
	$entryId = apiArgRequired("id");
	$admin = apiArgOptional("admin", false);
	$entry = $model->getEntry($entryId);
	$html = renderSignInSheetEntry($entry, false, $admin);
	respondOk($html);
} else if ($action == "dayentries") {
	$date = apiArgRequired("date");
	$admin = apiArgOptional("admin", false);
	$entries = $model->getEntriesForDate($date, "all");
	$topMessage = null;
	if ($admin) $topMessage = "Entries for " . date("l F jS", strtotime($date));
	$html = renderSignInSheetEntries($entries, false, $admin, $topMessage);
	respondOk($html);
} else if ($action == "newentryform") {
	$which = apiArgOptional("sheet", "visitor");
	if ($which == "child") {
		
	} else { // visitor
		respondOk(renderVisitorSignInForm());
	}
} else if ($action == "search") {
	$text = apiArgRequired("text");
	$entries = $model->searchEntries($text);
	if ($entries->count() == 0) {
		$topMessage = "No matches for \"" . $text . "\"";
	} else if ($entries->count() == 1) {
		$topMessage = "Found 1 match for \"" . $text . "\"";
	} else {
		$topMessage = "Found " . $entries->count() . " matches for \"" . $text . "\"";
	}
	$html .= renderSignInSheetEntries($entries, true, true, $topMessage);
	respondOk($html);
} else if ($action == "visitorsignout") {

	// returns displayable confirmation message

	$id = apiArgRequired("id");
	if ($model->visitorSignOut($id)) {
		respondOk("Thanks for visiting, enjoy the rest of your day!");
	} else {
		respondError("I can't find this entry...");
	}
} else if ($action == "delete") {

	// returns displayable confirmation message

	$id = apiArgRequired("id");
	if ($model->deleteEntry($id)) {
		respondOk("Thanks, the entry has been deleted.");
	} else {
		respondError("I can't find this entry...");
	}
} else if ($action == "visitorsignin") {
	
	// returns {id: <id>, markup: <markup for new entry>}
	
	$name = apiArgRequired("name");
	$purpose = apiArgRequired("purpose");
	$notes = apiArgOptional("notes", NULL);
	$entry = $model->visitorSignIn("asfs", $name, $purpose, $notes);
	if ($entry) {
		$html = renderSignInSheetEntry($entry, false);
		$data = array("id" => "" . $entry["_id"], "markup" => $html);
		respondOk(json_encode($data));
	} else {
		respondError("Uh oh, something bad happened.");
	}
} else {
	respondError("Invalid action specified");
	exit;
}
