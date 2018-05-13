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
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/countries/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.country.href = '/countries';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
