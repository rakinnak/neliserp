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
                this.form.submit('post', '/api/items')
                    .then(data => {
                        window.location.href = '/items';
                        //window.location.replace('/items');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
