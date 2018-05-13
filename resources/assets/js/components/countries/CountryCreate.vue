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
                this.form.submit('post', '/api/countries')
                    .then(data => {
                        window.country.href = '/countries';
                        //window.country.replace('/countries');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
