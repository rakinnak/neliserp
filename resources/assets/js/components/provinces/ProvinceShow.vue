<script>
    export default {
        props: ['uuid'],

        data() {
            return {
                province: {},
            }
        },

        created() {
            axios.get('/api/provinces/' + this.uuid)
                .then(response => {
                    this.province = response.data.data;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
