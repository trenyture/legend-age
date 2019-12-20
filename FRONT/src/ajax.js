import error  from './error.js'
import config from './config.js'

export default({
	toApi    = true,
	url      = "",
	method   = "GET",
	data     = null,
	dataType = "json",
	success  = () => {},
	always   = () => {},
	fail     = (err) => {
		error(err);
	},
} = {}) => {

	/**
	 * On construits nos headers et notre URL
	 * @type {Object}
	 */
	let headers = {
	};
	let newUrl = url;
	if(toApi) {
		newUrl = config.apiUrl + (url.length > 0 && url[0] == '/' ? url : '/'+url);
		newUrl = new URL(newUrl);
		/*headers["platform-sender"] = config.platformName;
		headers["session-token"] = store.getters['session/sessionId'];*/
	}

	method = method.toUpperCase();

	if(method === "PUT") {
		headers['Content-Type'] = 'application/x-www-form-urlencoded';
	}

	let obj = {
		mode: 'cors',
		method: method,
		headers: headers,
	};

	if(method !== "GET" && data !== null) {
		obj.body = data;
	}

	if(method === "PUT" && obj.body) {
		var object = {};
		data.forEach((value, key) => {object[key] = value});
		obj.body = JSON.stringify(object);
	}

	/**
	 * On envoit notre fetch
	 * @type {String}
	 */
	return fetch(newUrl, obj)
	.then(response => {
		//Si erreur
		if (!response.ok) {
			throw response;
		}
		else {
			response[dataType]().then(data => {
				success(data, response);
			});
		}
	})
	.catch(fail)
	.finally(always);
}