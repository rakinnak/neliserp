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
                this.form.submit('post', '/api/roles')
                    .then(data => {
                        window.location.href = '/roles';
                        //window.location.replace('/roles');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
