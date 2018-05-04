<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                person: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/persons/' + this.uuid)
                .then(response => {
                    this.person = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/persons/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/persons';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
