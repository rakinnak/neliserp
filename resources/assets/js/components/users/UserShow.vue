<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                user: {},
            }
        },

        created() {
            axios.get('/api/users/' + this.uuid)
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
