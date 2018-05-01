<script>
    export default {
        props: ['type', 'input'],

        data() {
            return {
                doc: {
                    uuid: '',
                    doc_item: [],
                },
                // companies: [],
                form: new Form({
                    company_code: '',
                    name: '',
                    issued_at: '2018-04-26',
                }),
                refer: false,
            }
        },
        mounted() {
            this.form.company_code = this.input.company_code;

            // TODO: show all items
            axios.get('/api/items?per_page=1000')
                .then(response => {
                    this.items = response.data.data;
                });

            if (this.input.doc_item.length == 0) {
                // TODO: should refactor
                this.doc.doc_item.push({
                    uuid: '',
                    line_number: 1,
                    item_uuid: '',
                    item_code: '',
                    quantity: '',
                    unit_price: '',
                    creating: true,
                    editing: false,
                    deleting: false,
                    deleted: false,
                    errors: {},
                    refer: '',
                })
            } else {
                this.refer = true;

                var line_number = 1;

                for (var doc_item_uuid in this.input.doc_item) {
                    axios.get('/api/doc_item/' + this.input.source_type + '/' + doc_item_uuid)
                        .then(response => {
                            var ref_doc_item = response.data.data;

                            // TODO: should refactor
                            this.doc.doc_item.push({
                                uuid: '',
                                line_number: line_number++,
                                item_uuid: '',
                                item_code: ref_doc_item.item_code,
                                quantity: ref_doc_item.pending_quantity,
                                unit_price: ref_doc_item.unit_price,
                                creating: true,
                                editing: false,
                                deleting: false,
                                deleted: false,
                                errors: {},
                                refer: ref_doc_item.doc_name,
                                ref_uuid: ref_doc_item.uuid,
                            })

                        });
                }
            }


            // typeahead autocomplete
            let api_token = document.head.querySelector('meta[name="api-token"]').content;

            var companies = new Bloodhound({
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
                remote: {
                    url: '/api/companies?api_token=' + api_token + '&per_page=1000&code=%QUERY',
                    wildcard: '%QUERY',
                    transform: function(data) {
                        return data.data;
                    }
                },
            });

            // TODO: temp solution to assign Vue variable from jQuery
            var vm = this;

            $('#company .typeahead').bind('typeahead:idle', function(ev) {
                vm.form.company_code = $(this).val();
            });

            $('#company .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1,
                dynamic: true,
                debug: true,
            },
            {
                source: companies,
                display: 'code',
                limit: 100,
                templates: {
                    notFound: function (data) {
                        return '<div class="tt-empty">+ add <strong>' + data.query + '</strong></div>';
                    },
                    suggestion: function(company) {
                        return '<div>' + company.code + ' : ' + company.name + '</div>';
                    },
                },
            });
        },

        methods: {
            onSubmit() {
                if (this.doc.uuid == '') {
                    // create
                    var method = 'post';
                } else {
                    // edit
                    var method = 'patch';
                }

                this.form.submit(method, '/api/docs/' + this.type + '/' + this.doc.uuid)
                    .then(data => {
                        console.log(data);
                        this.doc.uuid = data.uuid;
                        this.form.company_code = data.company_code;
                        this.form.name = data.name;
                        this.form.issued_at = data.issued_at;

                        var doc_type = this.type;
                        var doc_uuid = data.uuid;

                        // TODO: redirect to show page after added
                        var doc_item_creating_count = 0;

                        this.doc.doc_item.forEach(function (doc_item) {
                            if (doc_item.creating) {
                                doc_item_creating_count++;
                            }
                        });

                        if (doc_item_creating_count == 0) {
                            window.location.href = '/docs/' + this.type + '/' + this.doc.uuid;
                        }

                        console.log(doc_item_creating_count);

                        var doc_item_creating_success = 0;

                        this.doc.doc_item.forEach(function (doc_item) {
                            if (doc_item.creating) {
                                axios.post('/api/doc_item/' + this.type + '/' + this.doc.uuid, {
                                    ref_uuid: doc_item.ref_uuid,
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

                                    doc_item_creating_success++;

                                    if (doc_item_creating_count == doc_item_creating_success) {
                                        window.location.href = '/docs/' + this.type + '/' + this.doc.uuid;
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                    doc_item.errors = error.response.data.errors;
                                })
                            }
                        }, this);   // this bind in forEach loop

                    })
                    .catch(error => {
                        console.log(error);
                    })


            }
        }
    }
</script>

<style>
.typeahead,
.tt-query,
.tt-hint {
  /* width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 24px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none; */
}

.typeahead {
  background-color: #fff;
}

.typeahead:focus {
  border: 2px solid #0097cf;
}

.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-menu {
  width: 400px;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
  padding: 3px 20px;
  font-size: 18px;
  line-height: 24px;
}

.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}

.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;

}

.tt-suggestion p {
  margin: 0;
}

.tt-empty {
  padding: 3px 20px;
  /* font-size: 18px;
  line-height: 24px; */
}

.tt-empty:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
</style>
