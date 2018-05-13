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
                this.form.submit('post', '/api/provinces')
                    .then(data => {
                        window.province.href = '/provinces';
                        //window.province.replace('/provinces');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
