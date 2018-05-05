<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                role: {},
            }
        },

        created() {
            axios.get('/api/roles/' + this.uuid)
                .then(response => {
                    this.role = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
