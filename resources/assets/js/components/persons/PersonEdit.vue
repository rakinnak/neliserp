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

                    this.form.code = this.person.code;
                    this.form.name = this.person.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/persons/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/persons/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
