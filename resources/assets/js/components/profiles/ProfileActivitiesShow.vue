<script>
    export default {
        // props: ['uuid'],

        data() {
            return {
                activities: [],
            }
        },

        created() {
            axios.get('/api/profiles/activities')
                .then(response => {
                    this.activities = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },
    }
</script>
