<script>
    export default {
        data() {
            return {
                dataset: false,
                partners: [],
                done: false,
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

                var q = getParameterByName('q');

                return '/api' + location.pathname + '?q=' + q + '&page=' + page;
            },

            refresh(response) {
                this.dataset = response.data;
                this.partners = response.data.data;

                this.done = true;
            }

        }
    }
</script>
