<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                partner: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/partners/' + this.uuid)
                .then(response => {
                    this.partner = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/partners/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/partners';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
