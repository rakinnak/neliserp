<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                person: {},
            }
        },

        created() {
            axios.get('/api/persons/' + this.uuid)
                .then(response => {
                    this.person = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
