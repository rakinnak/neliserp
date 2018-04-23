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
                this.form.submit('post', '/api/companies')
                    .then(data => {
                        window.location.href = '/companies';
                        //window.location.replace('/companies');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
