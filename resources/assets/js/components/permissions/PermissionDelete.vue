<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                permission: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/permissions/' + this.uuid)
                .then(response => {
                    this.permission = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/permissions/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/permissions';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>
