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

                    this.form.code = this.city.code;
                    this.form.name = this.city.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/cities/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.city.href = '/cities/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
