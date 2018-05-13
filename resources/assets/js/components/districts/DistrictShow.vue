<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                district: {},
            }
        },

        created() {
            axios.get('/api/districts/' + this.uuid)
                .then(response => {
                    this.district = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
