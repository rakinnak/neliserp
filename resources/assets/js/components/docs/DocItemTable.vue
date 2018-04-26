<script>
    export default {
        props: ['doc', 'type'],

        data() {
            return {
                items: [],
            }
        },

        created() {
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
                console.log(doc_item);
                axios.post('/api/doc_item/' + this.type + '/' + this.doc.uuid, {
                    line_number: doc_item.line_number,
                    item_uuid: doc_item.item_uuid,
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
                axios.patch('/api/doc_item/' + doc_item.uuid, {
                    line_number: doc_item.line_number,
                    item_uuid: doc_item.item_uuid,
                    quantity: doc_item.quantity,
                    unit_price: doc_item.unit_price,
                })
                .then(data => {
                    doc_item.item_code = data.data.item_code;
                    doc_item.editing = false;
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