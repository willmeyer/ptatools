<?php
require_once("config.inc.php");
include("utils.inc.php");
include("model.inc.php");
include("ui.inc.php");

if (!deviceIsProvisioned()) {
	header('Location: provisioning.php?a=new');
}

include("pagetop.inc.php");

?>

<script>

	var _adminMode = false;

	$().ready(function() {
		setupIOSScaling();
		refreshDayUserView(today());
		initNewEntryForm();
		initDailyRefresher();
		/*
		window.setTimeout(function() {
			var bubble = new google.bookmarkbubble.Bubble();

		    var parameter = 'bmb=1';

		    bubble.hasHashParameter = function() {
		      return window.location.hash.indexOf(parameter) != -1;
		    };

		    bubble.setHashParameter = function() {
		      if (!this.hasHashParameter()) {
		        window.location.hash += parameter;
		      }
		    };
	    	bubble.showIfAllowed();
			}, 1000);
		*/
	});
</script>

<div id="topbar">
    <div id="topbar-inner">
        <h1>Welcome to ASFS</h1>
        <div id="topbar-buttons">
<!--
            <button class="sign-in">Visitor Sign-In</button>
            <button class="sign-out">Child Sign-Out</button>
-->
        </div>
    </div>
</div>
<div id="sidebar">
	<div id="newentry-container">
	</div>
</div>
<div id="rows-area">
	<div class="entries" id="entries">
	</div>
</div>

<?php
include("pagebottom.inc.php");
