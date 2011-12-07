function appendEntry(entryHtml) {
	$("#entries").append(entryHtml);
}		

function initNewEntryForm() {
	var call = "ajax.php?a=newentryform";
	$.ajax({
		dataType: "html",
	    url: call,
	    success: function(data) {
			$("#newentry-container").html(data);		
			$("#newentry-name").focus();
			
			$("#newentry-submit").click(function() {
				var call = "ajax.php?a=visitorsignin";
				if ($("#newentry-name").val() == "") {
					alert("Whoops, please sign in with your full name.");
					$("#newentry-name").focus();
					return false;
				}
				if ($("#newentry-name").val().trim().indexOf(" ") <= 0) {
					alert("Whoops, please enter both your first and last name.");
					$("#newentry-name").focus();
					return false;
				}
				call += "&name=" + $("#newentry-name").val();
				call += "&purpose=" + $("#newentry-purpose").val();
				call += "&notes=" + $("#newentry-notes").val();
				setLoading("#newentry");
				$("#newentry-submit").fadeOut();
				$.ajax({
					dataType: "json",
			        url: call,
			        success: function(data) {
						$("#newentry-name").val("");
						$("#newentry-child").val("");
						$("#newentry-purpose").val("classroom");
						$("#newentry-notes").val("");
						console.log("Received API response: ", data);
						appendEntry(data.markup);
						$('.row[entryid="' + data.id + '"]').fadeIn('slow', function() {
							//document.getElementById(data.id).scrollIntoView();
						});		
						alert("Thanks for signing in!  Enjoy your visit, and please remember to sign out before you leave.");
						//$("#newentry-name").focus();
						$('.row[entryid="' + data.id + '"]').focus();
			        },
			        error: function(xrd, status) {
						alert("Uh-Oh: " + status);
			        },
			        complete: function(data) {
						$("#newentry-submit").fadeIn();
			        }
			    });
				return false;
			});
			
	    },
	    error: function(xrd, status) {
			alert("Uh-Oh: " + status);
	    },
	    complete: function(data) {
	    }
	});
}

function setLoading(selector) {
//	$(selector).html('<img src="images/ajax-loader.gif"></img>');
	console.log("Turning on loading box...");
/*
	$.fancybox({
        'titleShow': false,
        'autoScale': true,
		'modal': true,
		'showCloseButton': false,
        'transitionIn': 'fade',
        'transitionOut': 'none',
        'type': 'iframe',
		'href': "images/ajax-loader.gif",
        'width': 50,
        'height': 50
    	});
*/
}

function onRefreshTick() {
	console.log("Refresh ticker fired...")
	refreshDayUserView(today());
}

function initDailyRefresher() {
	window.setInterval(onRefreshTick, 1000 * 60 * 60);
}

function setLoadingDone() {
	console.log("Turning off loading box...");
/*
	$.fancybox.close();
*/	
}

function formattedDate(date) {
	var str = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
	return str;
}

function today() {
	return formattedDate(new Date());
}

function deleteEntry(entryId) {
	var call = "ajax.php?a=delete";
	call += "&id=" + entryId;
	$.ajax({
		dataType: "html",
        url: call,
        success: function(data) {
			var selector = ".row[entryid=\"" + entryId + "\"]";
			console.log("Hiding selector: " + selector);
			alert(data);
			$(selector).hide('slow', function() {
				$(selector).remove();
			});
        },
        error: function(xrd, status) {
			alert("Uh-Oh: " + status);
        },
        complete: function(data) {
        }
    });
}

function refreshEntry(entryId, admin) {
	console.log("Refreshing entry " + entryId);
	var call = "ajax.php?a=getentry";
	call += "&admin=" + (admin ? "true" : "false");
	call += "&id=" + entryId;
	setLoading('.row[entryid="' + entryId + '"]');
	$.ajax({
		dataType: "html",
        url: call,
        success: function(data) {
			console.log("Received API response: ", data);
			var selector = '.row[entryid="' + entryId + '"]';
			$(selector).fadeOut();
			$(selector).replaceWith(data);
			$(selector).fadeIn('slow', function() {
				//document.getElementById(entryId).scrollIntoView();
			});
        },
        error: function(xrd, status) {
			alert("Uh-Oh: " + status);
        },
        complete: function(data) {
			setLoadingDone();
        }
    });
}

function signOutVisitor(entryId) {
	console.log("Signout clicked, entry " + entryId);
	$('.row[entryId="' + entryId + '"] .entry-signout').fadeOut();
	var call = "ajax.php?a=visitorsignout";
	call += "&id=" + entryId;
	$.ajax({
		dataType: "html",
        url: call,
        success: function(data) {
			alert(data);
			refreshEntry(entryId, _adminMode);
        },
        error: function(xrd, status) {
			alert("Uh-Oh: " + status);
        }
    });
}

/**
 * @param day YYYYMMDD
*/
function refreshDayUserView(day) {
	setLoading("#entries");
	$(".row").fadeOut();
	var call = "ajax.php?a=dayentries";
	call += "&date=" + day;
	$.ajax({
		dataType: "html",
        url: call,
        complete: function(data) {
			setLoadingDone();
        },
        success: function(data) {
			console.log("Loaded items for the day...");
			$("#entries").html(data);
			$(".row").fadeIn();
        },
        error: function(xrd, status) {
			alert("ERROR: " + status);
        }
    });
}

/**
 * @param day YYYYMMDD
*/
function refreshDayAdminView(day) {
	setLoading("#entries");
	$(".row").fadeOut();
	var call = "ajax.php?a=dayentries";
	call += "&date=" + day;
	call += "&type=all";
	call += "&admin=true";
	$.ajax({
		dataType: "html",
        url: call,
        complete: function(data) {
			setLoadingDone();
        },
        success: function(data) {
			$("#entries").html(data);
			$(".row").fadeIn();
        },
        error: function(xrd, status) {
			alert("ERROR: " + status);
        }
    });
}
