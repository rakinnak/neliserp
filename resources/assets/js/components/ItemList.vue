<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Items</div>

                    <div class="card-body">
                        <ul>
                            <li v-for="item in items">{{ item.code }} - {{ item.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
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
            axios.get('/api/items?api_token=' + api_token)
                .then(response => {
                    this.items = response.data.data;
                })
        }
    }
</script>
