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
                this.form.submit('post', '/api/districts')
                    .then(data => {
                        window.district.href = '/districts';
                        //window.district.replace('/districts');
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
