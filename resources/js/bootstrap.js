
try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('mdbootstrap');
} catch (e) {}

window.swal = require('sweetalert');

window.select2 = require('select2');

window.numeric = require('jquery.numeric');




/* 
	nuevo
	let token = document.head.querySelector('meta[name="csrf-token"]');

	if (token) {
	    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
	} else {
	    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
	}
*/
