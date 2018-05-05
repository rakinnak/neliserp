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

                    this.form.code = this.role.code;
                    this.form.name = this.role.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/roles/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/roles/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
