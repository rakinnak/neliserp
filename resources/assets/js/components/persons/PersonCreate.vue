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
                this.form.submit('post', '/api/persons')
                    .then(data => {
                        window.location.href = '/persons';
                        //window.location.replace('/persons');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
