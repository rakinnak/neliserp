<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                doc: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/docs/' + this.uuid)
                .then(response => {
                    this.doc = response.data.data;

                    this.form.code = this.doc.code;
                    this.form.name = this.doc.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/docs/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/docs/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
