<script>
    export default {
        data() {
            return {
                dataset: false,
                docs: [],
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

                var name = getParameterByName('name');

                return '/api' + location.pathname + '?name=' + name + '&page=' + page;
            },

            refresh(response) {
                this.dataset = response.data;
                this.docs = response.data.data;

                this.done = true;
            }

        }
    }
</script>
