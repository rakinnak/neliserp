<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                province: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/provinces/' + this.uuid)
                .then(response => {
                    this.province = response.data.data;

                    this.form.code = this.province.code;
                    this.form.name = this.province.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/provinces/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.province.href = '/provinces/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
