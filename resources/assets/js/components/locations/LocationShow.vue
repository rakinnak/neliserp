<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                location: {},
            }
        },

        created() {
            axios.get('/api/locations/' + this.uuid)
                .then(response => {
                    this.location = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
