<script>
    export default {
        props: ['type'],

        data() {
            return {
                doc: {
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
        },

        methods: {
            onSubmit() {

                var doc_item_length = this.doc.doc_item.length;
                var counter = 0;

                this.form.submit('post', '/api/docs/' + this.type)
                    .then(data => {
                        console.log(data);
                        this.doc.uuid = data.uuid;

                        var doc_type = this.type;
                        var doc_uuid = data.uuid;

                        // TODO: redirect to show page after added

                        this.doc.doc_item.forEach(function (doc_item) {
                            axios.post('/api/doc_item/' + doc_type + '/' + doc_uuid, {
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
                            })
                            .catch(error => {
                                console.log(error);
                                doc_item.errors = error.response.data.errors;
                            })
                        })

                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>
