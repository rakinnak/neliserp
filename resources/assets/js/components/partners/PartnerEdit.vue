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

                    this.form.code = this.partner.code;
                    this.form.name = this.partner.name;
                    this.form.first_name = this.partner.first_name;
                    this.form.last_name = this.partner.last_name;
                    this.form.subject = this.partner.subject;
                    this.subject = this.partner.subject;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/partners/' + this.role + '/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/partners/' + this.role + '/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
