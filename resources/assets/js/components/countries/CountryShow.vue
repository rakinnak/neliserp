<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                country: {},
            }
        },

        created() {
            axios.get('/api/countries/' + this.uuid)
                .then(response => {
                    this.country = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
