<script>
    export default {
        props: ['type', 'uuid'],

        data() {
            return {
                doc: {},
                companies: [],
                form: new Form({
                    company_code: '',
                    name: '',
                    issued_at: '',
                }),
                refer: false,
            }
        },

        mounted() {
            // TODO: show all companies
            // axios.get('/api/companies?per_page=1000')
            //     .then(response => {
            //         this.companies = response.data.data;
            //     });

            axios.get('/api/docs/' + this.type + '/' + this.uuid)
                .then(response => {
                    this.doc = response.data.data;

                    this.form.company_code = this.doc.company_code;
                    this.form.name = this.doc.name;
                    this.form.issued_at = this.doc.issued_at;
                })
                .catch(error => {
                    alert(error.response.status + ': ' + error.response.statusText);
                })

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

            $('.typeahead').bind('typeahead:idle', function(ev) {
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
                this.form.submit('patch', '/api/docs/' + this.type + '/' + this.uuid)
                    .then(data => {
                        // this.doc.doc_item.forEach(function (doc_item) {
                        //     axios.patch('/api/doc_item/' + doc_item.uuid, {
                        //         line_number: doc_item.line_number,
                        //         item_uuid: doc_item.item_uuid,
                        //         quantity: doc_item.quantity,
                        //         unit_price: doc_item.unit_price,
                        //     })
                        //     .then(data => {
                        //         console.log(data);
                        //     })
                        //     .catch(error => {
                        //         console.log(error);
                        //     })
                        // });

                        window.location.href = '/docs/' + this.type + '/' + this.uuid;
                    })
                    .catch(error => {
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