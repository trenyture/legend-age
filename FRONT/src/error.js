import alert from './alert';

function showError(err) {
	//Si on est sur du 403 c'est parce qu'on a pas accès à cette page
	let params = {
		title: err.message,
	};
	if(typeof err.details != "undefined" && err.details.length > 0) {
		let html = '';
		for(let i = 0; i < err.details.length; i++) {
			html += '<p>' + err.details[i] + '</p>';
		}
		params.message = html;
	}
	params.type = "error";
	alert.swal(params);
}

export default(error) => {
	//Fetch
	if(error instanceof Response) {
		error.json().then(e => {
			if(!e.message) e.message = error.statusText;
			showError(e);
		});
	}
	//NORMALLY
	else if (typeof error.response != "undefined") {
		showError(error.response);
	}
	//IF NO RESPONSE BUT REQUEST
	else if (typeof error.request != "undefined") {
		showError(JSON.parse(error.request.response));
	}
	//ERRORS FOR DATATABLES
	else if (typeof error.responseJSON != "undefined") {
		showError(error.responseJSON);
	}
	else{
		showError(error);
	}
}
