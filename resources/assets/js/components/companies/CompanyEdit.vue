<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                company: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/companies/' + this.uuid)
                .then(response => {
                    this.company = response.data.data;

                    this.form.code = this.company.code;
                    this.form.name = this.company.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/companies/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/companies/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
