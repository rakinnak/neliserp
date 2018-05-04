<script>
    export default {
        props: ['role'],

        data() {
            return {
                subject: '',
                form: new Form({
                    code: '',
                    name: ''
                }),
            }
        },
        methods: {
            selectSubject()
            {
                console.log('select')

            },

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
