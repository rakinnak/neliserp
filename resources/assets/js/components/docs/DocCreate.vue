<script>
    export default {
        props: ['type'],

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
                this.form.submit('post', '/api/docs/' + this.type)
                    .then(data => {
                        window.location.href = '/docs/' + this.type;
                        //window.location.replace('/docs/' + this.type);
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
