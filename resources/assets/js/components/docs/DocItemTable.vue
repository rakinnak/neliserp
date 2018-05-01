<script>
    export default {
        props: ['doc', 'type', 'refer'],

        data() {
            return {
                items: [],
            }
        },

        mounted() {
            // TODO: show all items
            axios.get('/api/items?per_page=1000')
                .then(response => {
                    this.items = response.data.data;
                });
        },

        methods: {
            addDocItemLine() {
                this.doc.doc_item.push({
                    uuid: '',
                    line_number: '',
                    item_uuid: '',
                    item_code: '',
                    quantity: '',
                    unit_price: '',
                    creating: true,
                    editing: false,
                    deleting: false,
                    deleted: false,
                    errors: {},
                })
            },
            createDocItem(doc_item) {
                axios.post('/api/doc_item/' + this.type + '/' + this.doc.uuid, {
                    line_number: doc_item.line_number,
                    item_code: doc_item.item_code,
                    quantity: doc_item.quantity,
                    unit_price: doc_item.unit_price,
                })
                .then(data => {
                    console.log(data);
                    doc_item.uuid = data.data.uuid;
                    doc_item.item_code = data.data.item_code;
                    doc_item.creating = false;
                })
                .catch(error => {
                    console.log(error);
                    doc_item.errors = error.response.data.errors;
                })
            },
            editDocItem(doc_item) {
                console.log('edit');
                axios.patch('/api/doc_item/' + doc_item.uuid, {
                    line_number: doc_item.line_number,
                    item_code: doc_item.item_code,
                    quantity: doc_item.quantity,
                    unit_price: doc_item.unit_price,
                })
                .then(data => {
                    doc_item.item_code = data.data.item_code;
                    doc_item.editing = false;

                    doc_item.pending_quantity = data.data.quantity;
                })
                .catch(error => {
                    doc_item.errors = error.response.data.errors;
                })
            },
            deleteDocItem(doc_item) {
                axios.delete('/api/doc_item/' + doc_item.uuid)
                .then(data => {
                    console.log(data);
                    doc_item.deleting = false;
                    doc_item.deleted = true;
                })
                .catch(error => {
                    console.log(error);
                })
            },
        }
    }
</script>
