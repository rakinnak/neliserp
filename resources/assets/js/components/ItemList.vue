<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h5>items</h5>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
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
                <tr v-for="item in items" :key="item.uuid">
                    <td>{{ item.code }}</td>
                    <td>{{ item.name }}</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            10 items
            <ul class="pagination mb-2 mb-md-0">
                <li class="page-item"><a class="page-link" href="#">&laquo; Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next &raquo;</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: [],
            }
        },

        mounted() {
            axios.get('/api/items')
                .then(response => {
                    this.items = response.data.data;
                })
        }
    }
</script>
