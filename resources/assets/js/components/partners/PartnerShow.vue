<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                partner: {},
            }
        },

        created() {
            axios.get('/api/partners/' + this.uuid)
                .then(response => {
                    this.partner = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
