<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                role: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/roles/' + this.uuid)
                .then(response => {
                    this.role = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/roles/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/roles';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
