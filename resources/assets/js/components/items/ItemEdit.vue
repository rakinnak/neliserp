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

                    this.form.code = this.item.code;
                    this.form.name = this.item.name;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

        methods: {
            onSubmit() {
                this.form.submit('patch', '/api/items/' + this.uuid)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/items/' + this.uuid;
                    })
                    .catch(error => {
                        // console.log(error);
                    })
            }
        }
    }
</script>