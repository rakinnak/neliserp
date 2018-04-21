<script>
    export default {
        data() {
            return {
                dataset: false,
                items: [],
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);
                    
                    page = query ? query[1] : 1;
                }

                return '/api' + location.pathname + '?page=' + page;
            },

            refresh(response) {
                this.dataset = response.data;
                this.items = response.data.data;
            }

        }
    }
</script>
