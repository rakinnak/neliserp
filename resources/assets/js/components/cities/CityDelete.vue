<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                city: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/cities/' + this.uuid)
                .then(response => {
                    this.city = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/cities/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.city.href = '/cities';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
