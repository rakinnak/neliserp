<template>
    <div id="item-code">
        <input class="form-control form-control-sm typeahead" type="text" id="item_code" name="item_code" placeholder="..." 
            autocomplete="off"
            v-model="doc_item.item_code"
            :class="{'is-invalid': doc_item.errors.hasOwnProperty('item_code')}">
        <!-- TODO: temp solution to display invalid-feedback -->
        <input class="form-control" type="hidden"
            :class="{'is-invalid': doc_item.errors.hasOwnProperty('item_code')}">
        <div class="invalid-feedback"
            v-if="doc_item.errors.hasOwnProperty('item_code')"
            v-text="doc_item.errors['item_code'][0]"></div>
    </div>
</template>

<script>
    export default {
        props: ['doc_item'],
        mounted() {
            // typeahead autocomplete
            let api_token = document.head.querySelector('meta[name="api-token"]').content;

            let items = new Bloodhound({
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('code'),
                remote: {
                    url: '/api/items?api_token=' + api_token + '&per_page=1000&code=%QUERY',
                    wildcard: '%QUERY',
                    transform: function(data) {
                        return data.data;
                    }
                },
            });

            // TODO: temp solution to assign Vue variable from jQuery
            var vm = this;

            $(this.$el).children('.typeahead').bind('typeahead:idle', function(ev) {
                vm.doc_item.item_code = $(this).val();
            });

            $(this.$el).children('.typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1,
                dynamic: true,
                debug: true,
            },
            {
                source: items,
                display: 'code',
                limit: 100,
                templates: {
                    notFound: function (data) {
                        return '<div class="tt-empty">not found <strong>' + data.query + '</strong></div>';
                    },
                    suggestion: function(item) {
                        return '<div>' + item.code + ' : ' + item.name + '</div>';
                    },
                },
            });
        }
    }
</script>