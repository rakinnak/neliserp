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
                this.form.submit('post', '/api/permissions')
                    .then(data => {
                        window.location.href = '/permissions';
                        //window.location.replace('/permissions');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
