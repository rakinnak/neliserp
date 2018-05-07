<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                user: {},
                form: new Form({
                    username: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/users/' + this.uuid)
                .then(response => {
                    this.user = response.data.data;

                    this.form.username = this.user.username;
                    this.form.name = this.user.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/users/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/users/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
