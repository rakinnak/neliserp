<template>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        from {{ metaFrom }}
        to {{ metaTo }},
        total {{ metaTotal }} items.
        <ul class="pagination mb-2 mb-md-0" v-if="hasPagination">
            <li class="page-item" v-if="prevUrl">
                <a class="page-link" href="#" @click="page--">&laquo;</a>
            </li>
            <!--
            <li class="page-item">
                <a class="page-link" href="#">1</a>
            </li>
            -->
            <li class="page-item" v-if="nextUrl">
                <a class="page-link" href="#" @click="page++">&raquo;</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
                metaFrom: 1,
                metaTo: 1,
                metaTotal: 1,
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.meta.current_page;
                this.prevUrl = this.dataSet.links.prev;
                this.nextUrl = this.dataSet.links.next;
                this.metaFrom = this.dataSet.meta.from;
                this.metaTo = this.dataSet.meta.to;
                this.metaTotal = this.dataSet.meta.total;
            },

            page() {
                this.broadcast();

                this.updateUrl();
            }

        },

        computed: {
            hasPagination() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
