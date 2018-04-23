<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                item: {},
                form: new Form({
                    code: '',
                    name: '',
                }),
            }
        },

        created() {
            axios.get('/api/items/' + this.uuid)
                .then(response => {
                    this.item = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('delete', '/api/items/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/items';
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>