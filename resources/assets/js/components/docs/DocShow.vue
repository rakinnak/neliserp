<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                doc: {},
            }
        },

        created() {
            axios.get('/api/docs/' + this.uuid)
                .then(response => {
                    this.doc = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
