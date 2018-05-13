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
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/provinces/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.province.href = '/provinces';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
