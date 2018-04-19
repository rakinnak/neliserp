<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>items</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-secondary">create</button>
                    <button class="btn btn-sm btn-outline-secondary">export</button>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>code</th>
                    <th>name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="items.length == 0">
                    <td colspan="2">
                        <i class="fa fa-spinner fa-spin"></i> loading data...
                    </td>
                </tr>
                <tr v-for="item in items" :key="item.uuid">
                    <td>{{ item.code }}</td>
                    <td>{{ item.name }}</td>
                </tr>
            </tbody>
        </table>

        <pagination :dataSet="dataSet" @changed="fetch"></pagination>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dataSet: false,
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
                this.dataSet = response.data;
                this.items = response.data.data;
            }

        }
    }
</script>
