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
                this.form.submit('post', '/api/locations')
                    .then(data => {
                        window.location.href = '/locations';
                        //window.location.replace('/locations');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
