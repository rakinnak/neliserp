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
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/companies/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/companies';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
