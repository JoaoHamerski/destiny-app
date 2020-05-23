import jQuery from 'jquery';

require('popper.js').default;
require('bootstrap');

window.$ = window.jQuery = jQuery;
window.axios = require('axios');

window.headers = {
	'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')
}