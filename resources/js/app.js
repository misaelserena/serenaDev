

require('./bootstrap');
require('mdbootstrap/js/mdb.min.js');
require('mdbootstrap/js/modules/forms-free.min.js');
require('@fortawesome/fontawesome-free/js/all.min.js');
require('./navbar');

Window.Vue = require('vue');
Vue.component('example-component',require('./components/ExampleComponent.vue').default);

const app = new Vue(
{
    el: '#app',
});
