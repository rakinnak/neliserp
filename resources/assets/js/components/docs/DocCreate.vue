<script>
    export default {
        props: ['type'],

        data() {
            return {
                doc: {
                    uuid: '',
                    doc_item: [],
                },
                companies: [],
                form: new Form({
                    company_uuid: '',
                    name: '',
                    issued_at: '2018-04-26',
                }),
            }
        },
        created() {
            // TODO: show all companies
            axios.get('/api/companies?per_page=1000')
                .then(response => {
                    this.companies = response.data.data;
                });

            // TODO: show all items
            axios.get('/api/items?per_page=1000')
                .then(response => {
                    this.items = response.data.data;
                });

            // TODO: should refactor
            this.doc.doc_item.push({
                uuid: '',
                line_number: '',
                item_uuid: '',
                item_code: '',
                quantity: '',
                unit_price: '',
                creating: true,
                editing: false,
                deleting: false,
                deleted: false,
                errors: {},
            })
        },

        methods: {
            onSubmit() {
                if (this.doc.uuid == '') {
                    // create
                    var method = 'post';
                } else {
                    // edit
                    var method = 'patch';
                }

                this.form.submit(method, '/api/docs/' + this.type + '/' + this.doc.uuid)
                    .then(data => {
                        console.log(data);
                        this.doc.uuid = data.uuid;
                        this.form.company_uuid = data.company_uuid;
                        this.form.name = data.name;
                        this.form.issued_at = data.issued_at;

                        var doc_type = this.type;
                        var doc_uuid = data.uuid;

                        // TODO: redirect to show page after added
                        var doc_item_creating_count = 0;

                        this.doc.doc_item.forEach(function (doc_item) {
                            if (doc_item.creating) {
                                doc_item_creating_count++;
                            }
                        });

                        if (doc_item_creating_count == 0) {
                            window.location.href = '/docs/' + this.type + '/' + this.doc.uuid;
                        }

                        console.log(doc_item_creating_count);

                        var doc_item_creating_success = 0;

                        this.doc.doc_item.forEach(function (doc_item) {
                            if (doc_item.creating) {
                                axios.post('/api/doc_item/' + this.type + '/' + this.doc.uuid, {
                                    line_number: doc_item.line_number,
                                    item_uuid: doc_item.item_uuid,
                                    quantity: doc_item.quantity,
                                    unit_price: doc_item.unit_price,
                                })
                                .then(data => {
                                    console.log(data);
                                    doc_item.uuid = data.data.uuid;
                                    doc_item.item_code = data.data.item_code;
                                    doc_item.creating = false;

                                    doc_item_creating_success++;

                                    if (doc_item_creating_count == doc_item_creating_success) {
                                        window.location.href = '/docs/' + this.type + '/' + this.doc.uuid;
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                    doc_item.errors = error.response.data.errors;
                                })
                            }
                        }, this);   // this bind in forEach loop

                    })
                    .catch(error => {
                        console.log(error);
                    })


            }
        }
    }
</script>
