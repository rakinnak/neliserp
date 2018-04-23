<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                item: {},
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

    }
</script>