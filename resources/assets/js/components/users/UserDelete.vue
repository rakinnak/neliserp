<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                user: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/users/' + this.uuid)
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/users/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/users';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
