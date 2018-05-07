<script>
    export default {
        // props: ['uuid'],

        data() {
            return {
                form: new Form({
                    // first_name: 'f',
                    // last_name: 'l',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/profiles/account')
                .then(response => {
                    this.form.name = response.data.data.name;
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
