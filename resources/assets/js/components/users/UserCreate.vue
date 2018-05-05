<script>
    export default {
        data() {
            return {
                form: new Form({
                    code: '',
                    name: ''
                }),
            }
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/api/users')
                    .then(data => {
                        window.location.href = '/users';
                        //window.location.replace('/users');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
