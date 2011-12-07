<?php
require_once("config.inc.php");
include("utils.inc.php");
include("model.inc.php");
include("ui.inc.php");
include("pagetop.inc.php");
?>

<div id="topbar">
    <div id="topbar-inner">
        <h1>Welcome to ASFS</h1>
    </div>
</div>
<div id="sidebar">
	<h1>Help & Setup</h1>
    <input type="button" value="Go to Visitor View" onclick="window.location.href='visitor.php'">
	<br/>
	<br/>
    <input type="button" value="Go to Front Desk View" onclick="window.location.href='frontdesk.php'">
</div>
<div id="rows-area">
	<div id="nonrows-content">
		<h2>Welcome</h2>
		<p>
			This is a PC/Laptop/iPad-based sign-in sheet. There are two pieces:
			<ul>
				<li>A <i>Visitor</i> interface that replaces a paper sign-in sheet. It's designed to be used mostly on an iPad. Use it <a href="./visitor.php">here</a>.</li>
				<li>A <i>Front Desk</i> interface, which administrators can use to view sheets for particular days and search for visitors. Access it <a href="frontdesk.php">here</a>.</li>
			</ul>
		</p>
		<h2>Setting up iPads</h2>
		<p>
			The first time you try to use the Visitor interface from a new computer or device, it will ask you to register it with the system.  To do so, you'll need the access code provided by your administrator.
		</p>
		<p>
			Once you have the device registered, you should add it to the Home Screen on the iPad to improve the experience -- click the Bookmark button in the browser bar, then Add to Home Screen.
		</p>
		<h2>Front Desk Security</h2>
		<p>
			The Front Desk interface requires access credentials, which are also provided by your administrator. This makes sure that only school staff can see full sheets.
		</p>
		<h2>Problems? Feature Requests?</h2>
		<p>
			Email <a href="mailto:will@willmeyer.com">Will</a> (Alex: 3rd grade, Nico: Kindergarden).
		</p>
	</div>
</div>
<?php
include("pagebottom.inc.php");

