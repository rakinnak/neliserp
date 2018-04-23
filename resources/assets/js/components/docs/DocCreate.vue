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
                this.form.submit('post', '/api/docs')
                    .then(data => {
                        window.location.href = '/docs';
                        //window.location.replace('/docs');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
