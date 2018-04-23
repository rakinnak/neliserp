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

Vue.component('item-index', require('./components/items/ItemIndex.vue'));
Vue.component('item-create', require('./components/items/ItemCreate.vue'));
Vue.component('item-show', require('./components/items/ItemShow.vue'));
Vue.component('item-edit', require('./components/items/ItemEdit.vue'));
Vue.component('item-delete', require('./components/items/ItemDelete.vue'));

Vue.component('company-index', require('./components/companies/CompanyIndex.vue'));
Vue.component('company-create', require('./components/companies/CompanyCreate.vue'));
Vue.component('company-show', require('./components/companies/CompanyShow.vue'));
Vue.component('company-edit', require('./components/companies/CompanyEdit.vue'));
Vue.component('company-delete', require('./components/companies/CompanyDelete.vue'));

Vue.component('doc-index', require('./components/docs/DocIndex.vue'));
Vue.component('doc-create', require('./components/docs/DocCreate.vue'));
Vue.component('doc-show', require('./components/docs/DocShow.vue'));
Vue.component('doc-edit', require('./components/docs/DocEdit.vue'));
Vue.component('doc-delete', require('./components/docs/DocDelete.vue'));

Vue.component('pagination', require('./components/Pagination.vue'));

window.Form = require('./Form');

window.getParameterByName = require('./functions');

const app = new Vue({
    el: '#app',
});
