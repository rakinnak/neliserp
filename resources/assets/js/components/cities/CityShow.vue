<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                city: {},
            }
        },

        created() {
            axios.get('/api/cities/' + this.uuid)
                .then(response => {
                    this.city = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
