<?php

/**
 *
 */
function renderSignInSheetEntries($entries, $showFullDates, $includeAdminOptions, $topMessage = null) {
	if ($topMessage) {
		$html = '<div id="topmessage">';
		$html .= $topMessage;
		$html .= '</div>';
	}
	foreach($entries as $entry) {
		$html .= renderSignInSheetEntry($entry, $showFullDates, $includeAdminOptions);
	}
	return $html;
}

function prettifyName($name) {
	return ucwords($name);
}

function renderSignInSheetEntry($entry, $showFullDate = false, $adminView = false) {
	if ($entry["exitTime"] == -1) {
		$class = "row";
	} else {
		$class = "row out";
	}
	$html = '<div class="' . $class . '" entryid="' . $entry["_id"] . '" id="' . $entry["_id"] . '" style="display:none">';
	$html .= '<h3 class="entry-name">' . prettifyName($entry["name"]) . '</h3>';
    $html .= '<table>';
	$html .= '  <tr>';     
    $html .= '    <td>';
	$html .= '    Signed In: <span class="blk">';
	$html .= '    ' . (($showFullDate) ? date("n/j/Y g:i A", $entry["entryTime"]) : date("g:i A", $entry["entryTime"]));
	$html .= '    </span>';
	$html .= '    </td>';
    $html .= '    <td><span class="entry-purpose">' . purposeMarkup($entry["purpose"]) . '</span>&nbsp;</td>';
    $html .= '    <td><span class="entry-signout">';
	if ($entry["exitTime"] == -1) {
		$html .= '    <input type="button" class="entry-signout" onclick="signOutVisitor(\'' . $entry["_id"] . '\')" entryid="' . $entry["_id"] . '" value="Sign Out">';
	} else {
		$html .= 'Out: ' . date("g:i A", $entry["exitTime"]);
	}
    $html .= '    </span></td>';
	if ($adminView) {
	    $html .= '    <td><span class="entry-delete">';
		$html .= '    <input type="button" class="entry-delete" onclick="deleteEntry(\'' . $entry["_id"] . '\')" value="Delete">';
		//$html .= '    <img id="entry-delete" onclick="deleteEntry(\'' . $entry["_id"] . '\')" src="images/close.png"></img>';
	    $html .= '    </span></td>';
	}
    $html .= '  </tr>';
	$html .= '</table>';
	$html .= '</div>';
	return $html;
}

function renderVisitorSignInForm() {
	include ("visitorsigninform.php");
}

function purposeMarkup($purpose) {
	if ($purpose == "classroom") {
		return "Visiting classroom";
	} else if ($purpose == "teacher") {
		return "Meeting with teacher";
	} else if ($purpose == "business") {
		return "School Business";
	} else {
		return "Other Purpose";
	}
}

?>