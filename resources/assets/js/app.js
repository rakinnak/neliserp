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
Vue.component('pagination', require('./components/Pagination.vue'));

class Errors {
    constructor() {
        this.errors = {};
    }

    record(errors) {
        this.errors = errors;
    }

    any() {
        return Object.keys(this.errors).length > 0;

    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    clear(field) {
        delete this.errors[field];
    }
}

const app = new Vue({
    el: '#app',
    data: {
        code: '',
        name: '',
        errors: new Errors(),
    },
    methods: {
        onSubmit() {
            axios.post('/api/items', this.$data)
                .then(this.onSuccess)
                .catch(error => {
                    this.errors.record(error.response.data.errors);
                })
        },

        onSuccess(response) {
            this.code = '';
            this.name = '';
        }
    }
});
