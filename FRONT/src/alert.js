import toastr       from 'toastr'
import Swal         from 'sweetalert2'

toastr.options = {
	closeButton: true,
	debug: false,
	newestOnTop: true,
	progressBar: true,
	preventDuplicates: false,
	onclick: null,
	showDuration: 300,
	hideDuration: 300,
	timeOut: 2000,
	extendedTimeOut: 1000,
	showEasing: "swing",
	hideEasing: "linear",
	showMethod: "fadeIn",
	hideMethod: "fadeOut"
}

function swalObject(obj) {
	if(typeof obj.cancel != 'undefined'){
		obj.cancelButtonText = obj.cancel;
		obj.showCancelButton = true;
	}
	if(typeof obj.confirm != 'undefined'){
		obj.confirmButtonText = obj.confirm;
		obj.showConfirmButton = true;
	}
	if(typeof obj.cancel == 'undefined' && typeof obj.confirm == 'undefined') {
		obj.timeOut = 3500;
		obj.extendedTimeOut = 1500;
	}

	return {
		title:              (typeof obj.title              !== "undefined") ? obj.title              :  "",
		html:               (typeof obj.message            !== "undefined") ? obj.message            :  "",
		type:               (typeof obj.type               !== "undefined") ? obj.type               :  "info",
		confirmButtonText:  (typeof obj.confirm            !== "undefined") ? obj.confirm            :  'Yes',
		showConfirmButton:  (typeof obj.confirm            !== "undefined") ? true                   :  false,
		cancelButtonText:   (typeof obj.cancel             !== "undefined") ? obj.cancel             :  'No',
		showCancelButton:   (typeof obj.cancel             !== "undefined") ? true                   :  false,
		showCloseButton:    (typeof obj.showCloseButton    !== "undefined") ? obj.showCloseButton    :  true,
		timer:              (typeof obj.timer              !== "undefined") ? obj.timer              : null,
		confirmButtonClass: 'btn btn-primary',
		cancelButtonClass:  'btn btn-outline-secondary',
		buttonsStyling:     false,
		reverseButtons:     true,
	}
}

export default {

	swal: function(obj) {
		return Swal.fire(swalObject(obj))
			.then((typeof obj.callback !== "undefined")
				? obj.callback
				: () => {}
			)
	},

	toast: function({
		type = "info",
		message = "",
		title = "",
	} = {}) {
		return toastr[type](message, title);
	}
}