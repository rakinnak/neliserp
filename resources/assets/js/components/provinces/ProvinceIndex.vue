<script>
    export default {
        data() {
            return {
                dataset: false,
                provinces: [],
                done: false,
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page) {
                // console.log(this.url(page));
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page) {
                if (! page) {
                    let query = province.search.match(/page=(\d+)/);
                    
                    page = query ? query[1] : 1;
                }

                var q = getParameterByName('q');

                return '/api' + province.pathname + '?q=' + q + '&page=' + page;
            },

            refresh(response) {
                this.dataset = response.data;
                this.provinces = response.data.data;

                this.done = true;
            }

        }
    }
</script>
