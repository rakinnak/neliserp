<script>
    export default {
        data() {
            return {
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/api/items')
                    .then(data => {
                        // console.log(data);
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>