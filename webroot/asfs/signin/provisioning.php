<?php
require_once("config.inc.php");
include("utils.inc.php");
include("model.inc.php");
include("ui.inc.php");

function renderForm() {
	?>
	<br/>
	<br/>
	<form id="provisioningform" action="provisioning.php" method = "post">
	Access Code: <input type = "text" name = "code" autocorrect="off" autocapitalize="off" />
	<br/>
	<br/>
	<br/>
	<br/>
	<input type = "hidden" name = "a" value="provision" />
    <input type="button" value="Register Now" onclick="document.forms['provisioningform'].submit();">
	</form>
	<?php
}

// Do basics; if we're provisioning/deprovisioning, set the cookie first
$action = getDfltArg("a", "status");
if ($action == "provision") {
	$code = getDfltArg("code", NULL);
	if ($code == CREDS_DEVICECODE) {
		setcookie("asfs", "provisioned", time() + 3600*24*365*10, "/");
	}
} else if ($action == "deprovision") {
	setcookie("asfs", "deprovisioned", time() + 3600*24*365*10, "/");
}

// Ok now do the main work
include("pagetop.inc.php");
?>

<div id="topbar">
    <div id="topbar-inner">
        <h1>Welcome to ASFS</h1>
    </div>
</div>
<div id="sidebar">
	<h1>Device Setup</h1>
</div>
<div id="rows-area">
<div id="nonrows-content">
<?php
	if ($action == "new") {
		?>
		<h2>Please Register this Device</h2>
		<p>
			To use the sign-in sheet on this device, you need to register it.
		</p>  
		<p>
			Please enter the device access code given to you by your administrator.
		</p>
		<?php
		renderForm();
	} else if ($action == "provision") {
		$code = getDfltArg("code", NULL);
		if ($code == CREDS_DEVICECODE) {
			?>
			<h2>Device Registered</h2>
			<p>
				Great, this device is all set up.
			</p>
			<input type="button" value="Go to the App Now" onclick="window.location.href='visitor.php'">
			<?php
		} else {
			?>
			<h2>Sorry</h2>
			<p>
				That access code isn't right.  Try again?
			</p>  
			<?php
			renderForm();
		}
		
		?>
		<?php  
	} else if ($action == "status") {
		echo "<h2>Registration Status</h2>";
		if (deviceIsProvisioned()) {
			echo 'This device is registered.<br/><br/>';
			echo '<input type="button" value="Unregister this device" onclick="window.location.href=\'provisioning.php?a=deprovision\'">';
		} else {
			echo 'This device is NOT registered.<br/><br/>';
			echo '<input type="button" value="Register this device" onclick="window.location.href=\'provisioning.php?a=new\'">';
		}		
	} else if ($action == "deprovision") {
		echo "<h2>Unregistered</h2>";
		echo 'This device is now unregistered.';
	} else {
		?>
		<p>
			Sorry, something went wrong.  <a href="provisioning.php">Try again</a>
		</p>
		<?php  
	}

?>
</div>
</div>
<?php
include("pagebottom.inc.php");
