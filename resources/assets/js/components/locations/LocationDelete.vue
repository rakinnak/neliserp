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
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/locations/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/locations';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
