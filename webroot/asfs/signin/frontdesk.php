<?php
require_once("config.inc.php");
include("utils.inc.php");
include("model.inc.php");
include("ui.inc.php");

session_start();
if ($_SESSION["loggedin"] != "true") {
	header("Location: login.php");
}

include("pagetop.inc.php");

?>
<script>

	var _adminMode = true;
	
	$().ready(function() {
		refreshDayAdminView(today());		
		setupCalendarPicker();
		setupSearch();
		setupReporting();
	});

	function handleSelect(type,args,obj) {
		var dates = args[0];
		var date = dates[0];
		var year = date[0], month = date[1], day = date[2];
		refreshDayAdminView(year + "-" + month + "-" + day);
		$("#search-name").val("");		
	}
	
	function setupCalendarPicker() {
		var myCalendar = new YAHOO.widget.Calendar("cal", "cal-container");
		myCalendar.cfg.setProperty("selected",today(),false);
		myCalendar.render();		
		myCalendar.selectEvent.subscribe(handleSelect, myCalendar, true); 
	}

	function setupReporting() {
		$("#print-go").click(function() {
			alert("Not done yet...could do an email instead too...");
		});
	}
	
	function setupSearch() {
		$("#search-name").val("");		
		$("#search-go").click(function() {
			//$(this).fadeOut();
			var call = "ajax.php?a=search";
			if ($("#search-name").val() == "") {
				alert("Please enter all or part of a name to search...");
				return;
			}
			call += "&text=" + $("#search-name").val();
			setLoading("#entries");
			$.ajax({
				dataType: "html",
		        url: call,
		        success: function(data) {
					$("#entries").html(data);
					window.scrollTo(0,0);
		        },
		        error: function(xrd, status) {
					alert("Uh-Oh: " + status);
		        },
		        complete: function(data) {
					setLoadingDone();
					$(".row").fadeIn();
					//$("#search-go").fadeIn();
		        }
		    });
		});
		
	}
	
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
	<div id="search">
		<h3>Search Visitors</h3>
		<label>
		Look for sign-ins and sign-outs.
		</label>
		<input type="text" size="20" name="search-name" id="search-name"></input><br/><br/>
		<input type="button" name="search-go" id="search-go" value="Search"></input>
	</div>
	<div id="dateview">
		<h3>Daily Sheets</h3>
		<label>
			View the sheet for a given day.
		</label>
		<div id="cal-container"></div>
	</div>
	<div id="reports">
		<h3>Reporting</h3>
		<label>
			Print or email the current page.</br/></br/>
			<input type="button" name="print-go" id="print-go" value="Print"></input>
		</label>
	</div>
</div>
<div id="rows-area">
	<div class="entries" id="entries">
	</div>
</div>

<?php
include("pagebottom.inc.php");
