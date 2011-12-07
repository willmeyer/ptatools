const ON = false;

function dbglog(msg) {
	if (ON && console) {
		console.log(msg);
	}
}