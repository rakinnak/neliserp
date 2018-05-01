<script>
    export default {
        props: ['type', 'uuid'],

        data() {
            return {
                doc: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
                refer: false,
            }
        },

        created() {
            axios.get('/api/docs/' + this.type + '/' + this.uuid)
                .then(response => {
                    this.doc = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/docs/' + this.type + '/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/docs/' + this.type;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
