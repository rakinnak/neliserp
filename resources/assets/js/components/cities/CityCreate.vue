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
                this.form.submit('post', '/api/cities')
                    .then(data => {
                        window.city.href = '/cities';
                        //window.city.replace('/cities');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
