<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                permission: {},
            }
        },

        created() {
            axios.get('/api/permissions/' + this.uuid)
                .then(response => {
                    this.permission = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
