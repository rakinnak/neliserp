<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                district: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/districts/' + this.uuid)
                .then(response => {
                    this.district = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/districts/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.district.href = '/districts';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
