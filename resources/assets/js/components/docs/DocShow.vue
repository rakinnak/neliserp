<script>
    export default {
        props: ['type', 'uuid'],

        data() {
            return {
                doc: {},
            }
        },

        created() {
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
