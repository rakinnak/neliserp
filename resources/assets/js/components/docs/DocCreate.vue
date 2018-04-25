<script>
    export default {
        props: ['type'],

        data() {
            return {
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
        },

        methods: {
            onSubmit() {
                this.form.submit('post', '/api/docs/' + this.type)
                    .then(data => {
                        window.location.href = '/docs/' + this.type;
                        //window.location.replace('/docs/' + this.type);
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
