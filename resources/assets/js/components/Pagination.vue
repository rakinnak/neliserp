<script>
    export default {
        props: ['dataset', 'appends'],

        data() {
            return {
                page: 1,
                pages: 1,
                prevUrl: false,
                nextUrl: false,
                metaFrom: 1,
                metaTo: 1,
                metaTotal: 1,
            }
        },

        watch: {
            dataset() {
                this.page = this.dataset.meta.current_page;
                this.pages = this.dataset.meta.last_page;
                this.prevUrl = this.dataset.links.prev;
                this.nextUrl = this.dataset.links.next;
                this.metaFrom = this.dataset.meta.from;
                this.metaTo = this.dataset.meta.to;
                this.metaTotal = this.dataset.meta.total;
            },

            page() {
                this.broadcast();

                this.updateUrl();
            }
        },

        computed: {
            hasPagination() {
                return !! this.prevUrl || !! this.nextUrl;
            },
        },

        methods: {
            broadcast() {
                this.$emit('changed', this.page);
            },

            updateUrl() {
                // history.pushState(null, null, '?page=' + this.page);
            },

            href(page) {
                var href = '?page=' + page;

                if (this.appends) {
                    href += '&q=' + this.appends['q'];
                }

                return href;
            }
        }
    }
</script>
