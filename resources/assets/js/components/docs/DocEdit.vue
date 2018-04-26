<script>
    export default {
        props: ['type', 'uuid'],

        data() {
            return {
                doc: {},
                companies: [],
                form: new Form({
                    company_uuid: '',
                    name: '',
                    issued_at: '',
                }),
            }
        },

        created() {
            // TODO: show all companies
            axios.get('/api/companies?per_page=1000')
                .then(response => {
                    this.companies = response.data.data;
                });

            axios.get('/api/docs/' + this.type + '/' + this.uuid)
                .then(response => {
                    this.doc = response.data.data;

                    this.form.company_uuid = this.doc.company_uuid;
                    this.form.name = this.doc.name;
                    this.form.issued_at = this.doc.issued_at;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/docs/' + this.type + '/' + this.uuid)
                    .then(data => {
                        // this.doc.doc_item.forEach(function (doc_item) {
                        //     axios.patch('/api/doc_item/' + doc_item.uuid, {
                        //         line_number: doc_item.line_number,
                        //         item_uuid: doc_item.item_uuid,
                        //         quantity: doc_item.quantity,
                        //         unit_price: doc_item.unit_price,
                        //     })
                        //     .then(data => {
                        //         console.log(data);
                        //     })
                        //     .catch(error => {
                        //         console.log(error);
                        //     })
                        // });

                        window.location.href = '/docs/' + this.type + '/' + this.uuid;
                    })
                    .catch(error => {
                    })

            }
        }
    }
</script>
