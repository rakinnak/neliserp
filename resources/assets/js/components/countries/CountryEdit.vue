<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                country: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/countries/' + this.uuid)
                .then(response => {
                    this.country = response.data.data;

                    this.form.code = this.country.code;
                    this.form.name = this.country.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/countries/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.country.href = '/countries/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
