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
        if (field) {
            delete this.errors[field];

            return;
        }

        this.errors = {};
    }
}

class Form {
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }

    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data.errors)
                    reject(error.response.data.errors)
                })
        });
    }

    onSuccess(data) {
        alert('onSuccess');

        this.reset();
    }

    onFail(errors) {
        this.errors.record(errors);
    }
}

const app = new Vue({
    el: '#app',
    data: {
        form: new Form({
            code: '',
            name: '',
        }),
    },
    methods: {
        onSubmit() {
            this.form.submit('post', '/api/items')
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
});
