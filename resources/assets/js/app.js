import Axios from 'axios';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('item-list', require('./components/ItemList.vue'));
Vue.component('item-create', require('./components/ItemCreate.vue'));
Vue.component('item-show', require('./components/ItemShow.vue'));
Vue.component('item-edit', require('./components/ItemEdit.vue'));
Vue.component('item-delete', require('./components/ItemDelete.vue'));

Vue.component('pagination', require('./components/Pagination.vue'));

window.Form = require('./Form');

window.getParameterByName = require('./functions');

const app = new Vue({
    el: '#app',
});
