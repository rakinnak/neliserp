<script>
    export default {
        props: ['role'],

        data() {
            return {
                subject: '',
                form: new Form({
                    code: '',
                    name: '',
                    subject: '',
                    first_name: '',
                    last_name: ''
                }),
            }
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/api/partners/' + this.role)
                    .then(data => {
                        window.location.href = '/partners/' + this.role;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
