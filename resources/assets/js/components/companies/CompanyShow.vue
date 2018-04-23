<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                company: {},
            }
        },

        created() {
            axios.get('/api/companies/' + this.uuid)
                .then(response => {
                    this.company = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
