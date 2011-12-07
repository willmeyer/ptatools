<?php
require_once("config.inc.php");
include("utils.inc.php");
include("model.inc.php");
include("ui.inc.php");
session_start();
include("pagetop.inc.php");

function renderForm() {
	?>
	<form id="loginform" action="login.php" method = "post">
	Username: <input type = "text" name = "u" autocorrect="off" autocapitalize="off" /></br></br>
	Password: <input type = "password" name = "p" /></br>
	<input type = "hidden" name = "a" value="login" /><br/>
    <input type="button" value="Log In" onclick="document.forms['loginform'].submit();">
	</form>
	<?php
}

$action = getDfltArg("a", "form");

?>

<div id="topbar">
    <div id="topbar-inner">
        <h1>Welcome to ASFS</h1>
    </div>
</div>
<div id="sidebar">
	<h1>Front Desk Login</h1>
</div>
<div id="rows-area">
<div id="nonrows-content">
<?php
	if ($action == "form") {
		?>
		<h2>Username and Password?</h2>
		<p>
			To use the Front Desk interface, you need to log in.
		</p>  
		<?php
		renderForm();
	} else if ($action == "logout") {
		$_SESSION["loggedin"] = "false";
		?>
		<h2>Bye</h2>
		<p>
			See you later, thanks!
		</p>
		<?php  
	} else if ($action == "login") {
		$username = getDfltArg("u", NULL);
		$password = getDfltArg("p", NULL);
		if ((strtolower($username) == CREDS_USERNAME) && (strtolower($password) == CREDS_PASSWORD)) {
			$_SESSION["loggedin"] = "true";
			?>
			<h2>Welcome!</h2>
			<p>
				Great, you're all set.
			</p>  
			<input type="button" value="Go to Front Desk View" onclick="window.location.href='frontdesk.php'">
			<?php
		} else {
			?>
			<h2>Sorry</h2>
			<p>
				Those credentials aren't right.  Try again?
			</p>  
			<?php
			renderForm();
		}
		
		?>
		<?php  
	} else {
		?>
		<p>
			Sorry, something went wrong.  <a href="login.php">Try again</a>
		</p>
		<?php  
	}
?>
</div>
</div>
<?php
include("pagebottom.inc.php");
