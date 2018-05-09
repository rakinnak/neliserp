<script>
    export default {
        // props: ['uuid'],

        data() {
            return {
                form: new Form({
                    name: '',
                    first_name: '',
                    last_name: '',
                }),
            }
        },

        created() {
            axios.get('/api/profiles/account')
                .then(response => {
                    this.form.name = response.data.data.name;
                    this.form.first_name = response.data.data.first_name;
                    this.form.last_name = response.data.data.last_name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/profiles/account')
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/profiles/account';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
