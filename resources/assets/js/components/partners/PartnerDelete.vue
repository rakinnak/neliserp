<script>
    export default {
        props: ['role', 'uuid'],

        data() {
            return {
                subject: '',
                partner: {},
                form: new Form({
                    code: '',
                    name: '',
                    subject: '',
                    first_name: '',
                    last_name: ''
                }),
            }
        },

        created() {
            axios.get('/api/partners/' + this.role + '/' + this.uuid)
                .then(response => {
                    this.partner = response.data.data;
                    this.subject = this.partner.subject;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/partners/' + this.role + '/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/partners/' + this.role;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
