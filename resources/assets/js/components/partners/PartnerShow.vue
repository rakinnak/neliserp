<script>
    export default {
        props: ['role', 'uuid'],

        data() {
            return {
                subject: '',
                partner: {},
            }
        },

        created() {
            axios.get('/api/partners/' + this.role + '/' + this.uuid)
                .then(response => {
                    this.partner = response.data.data;
                    this.subject = this.partner.subject;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })
        },

    }
</script>
