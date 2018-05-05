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

Vue.component('person-index', require('./components/persons/PersonIndex.vue'));
Vue.component('person-create', require('./components/persons/PersonCreate.vue'));
Vue.component('person-show', require('./components/persons/PersonShow.vue'));
Vue.component('person-edit', require('./components/persons/PersonEdit.vue'));
Vue.component('person-delete', require('./components/persons/PersonDelete.vue'));

Vue.component('partner-index', require('./components/partners/PartnerIndex.vue'));
Vue.component('partner-create', require('./components/partners/PartnerCreate.vue'));
Vue.component('partner-show', require('./components/partners/PartnerShow.vue'));
Vue.component('partner-edit', require('./components/partners/PartnerEdit.vue'));
Vue.component('partner-delete', require('./components/partners/PartnerDelete.vue'));

Vue.component('doc-index', require('./components/docs/DocIndex.vue'));
Vue.component('doc-create', require('./components/docs/DocCreate.vue'));
Vue.component('doc-show', require('./components/docs/DocShow.vue'));
Vue.component('doc-edit', require('./components/docs/DocEdit.vue'));
Vue.component('doc-delete', require('./components/docs/DocDelete.vue'));
Vue.component('doc-item-table', require('./components/docs/DocItemTable.vue'));
Vue.component('doc-move', require('./components/docs/DocMove.vue'));

Vue.component('doc-item-code', require('./components/docs/DocItemCode.vue'));

Vue.component('doc-item-index', require('./components/doc_items/DocItemIndex.vue'));

Vue.component('user-index', require('./components/users/UserIndex.vue'));
Vue.component('user-create', require('./components/users/UserCreate.vue'));
Vue.component('user-show', require('./components/users/UserShow.vue'));
Vue.component('user-edit', require('./components/users/UserEdit.vue'));
Vue.component('user-delete', require('./components/users/UserDelete.vue'));

Vue.component('role-index', require('./components/roles/RoleIndex.vue'));
Vue.component('role-create', require('./components/roles/RoleCreate.vue'));
Vue.component('role-show', require('./components/roles/RoleShow.vue'));
Vue.component('role-edit', require('./components/roles/RoleEdit.vue'));
Vue.component('role-delete', require('./components/roles/RoleDelete.vue'));

Vue.component('permission-index', require('./components/permissions/PermissionIndex.vue'));
Vue.component('permission-create', require('./components/permissions/PermissionCreate.vue'));
Vue.component('permission-show', require('./components/permissions/PermissionShow.vue'));
Vue.component('permission-edit', require('./components/permissions/PermissionEdit.vue'));
Vue.component('permission-delete', require('./components/permissions/PermissionDelete.vue'));

Vue.component('pagination', require('./components/Pagination.vue'));

window.Form = require('./Form');

window.getParameterByName = require('./functions');

const app = new Vue({
    el: '#app',
});
