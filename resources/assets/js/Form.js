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
        // alert('onSuccess');

        this.reset();
    }

    onFail(errors) {
        this.errors.record(errors);
    }
}

module.exports = Form;