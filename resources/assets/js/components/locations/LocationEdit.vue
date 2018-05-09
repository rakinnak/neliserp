<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                location: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/locations/' + this.uuid)
                .then(response => {
                    this.location = response.data.data;

                    this.form.code = this.location.code;
                    this.form.name = this.location.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/locations/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/locations/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
