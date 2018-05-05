<script>
    export default {
        props: ['type', 'uuid'],

        data() {
            return {
                doc: {
                },
                form: new Form({
                    partner_code: '',
                    name: '',
                    issued_at: '',
                }),
                refer: false,
            }
        },

        mounted() {
            axios.get('/api/docs/' + this.type + '/' + this.uuid)
                .then(response => {
                    this.doc = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
