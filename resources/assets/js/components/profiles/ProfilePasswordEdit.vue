<script>
    export default {
        // props: ['uuid'],

        data() {
            return {
                form: new Form({
                    old_password: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        created() {
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/profiles/password')
                    .then(data => {
                        console.log(data);
                        // window.location.href = '/profiles/password';
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>
