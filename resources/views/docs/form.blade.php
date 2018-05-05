<div class="row">
    <div class="col-md-4 mb-3">
        <label for="partner_code" id="partner">{{ __('docs.partner_code') }}</label>
        @if ($action == 'show' || $action == 'delete' || $action == 'move')
            <input type="text" class="form-control-plaintext" id="partner_code" name="partner_code" :value="doc.partner_code" :readonly="true">
        @elseif ($action == 'create' || $action == 'edit')
            <div id="partner">
                <input class="form-control form-control-sm typeahead" type="text" id="partner_code" name="partner_code" placeholder="code..." 
                    autocomplete="off" v-model="form.partner_code" :class="{'is-invalid': form.errors.has('partner_code')}">
                <!-- TODO: temp solution to display invalid-feedback -->
                <input class="form-control form-control-sm" type="hidden" :class="{'is-invalid': form.errors.has('partner_code')}">
                <div class="invalid-feedback" v-if="form.errors.has('partner_code')" v-text="form.errors.get('partner_code')"></div>
            </div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="name">{{ __('docs.name') }}</label>
        @if ($action == 'show' || $action == 'delete' || $action == 'move')
            <input type="text" class="form-control-plaintext" id="name" name="name" :value="doc.name" :readonly="true">
        @elseif ($action == 'create' || $action == 'edit')
            <input type="text" class="form-control form-control-sm" :class="{'is-invalid': form.errors.has('name')}"
                id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="issued_at">{{ __('docs.issued_at') }}</label>
        @if ($action == 'show' || $action == 'delete' || $action == 'move')
            <input type="text" class="form-control-plaintext" id="issued_at" name="issued_at" :value="doc.issued_at" :readonly="true">
        @elseif ($action == 'create' || $action == 'edit')
            <input type="text" class="form-control form-control-sm" :class="{'is-invalid': form.errors.has('issued_at')}" id="issued_at" name="issued_at" value="" v-model="form.issued_at" placeholder="YYYY-MM-DD">
            <div class="invalid-feedback" v-if="form.errors.has('issued_at')" v-text="form.errors.get('issued_at')"></div>
        @endif
    </div>
</div>

<doc-item-table :doc="doc" :type="type" :refer="refer" inline-template>
    <table class="table table-bordered">
        <thead>
            <tr>
                <template v-if="doc.moving">
                    <th>
                        <input type="checkbox">
                    </th>
                </template>
                <th>{{ __('doc_item.line_number') }}</th>
                <template v-if="refer">
                    <th>
                        {{ __('ref.') }}
                    </th>
                </template>
                <th>{{ __('doc_item.item_code') }}</th>
                <th>{{ __('doc_item.quantity') }}</th>
                <th>{{ __('doc_item.unit_price') }}</th>
                <th>{{ __('doc_item.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if ($action == 'show' || $action == 'delete' || $action == 'move')
                <tr v-for="doc_item in doc.doc_items" :class="{'table-info' : doc_item.editing, 'table-danger' : doc_item.deleting}">
                    <template v-if="doc.moving">
                        <td>
                            <template v-if="doc_item.pending_quantity > 0">
                                <input type="checkbox" checked :name="'doc_items[' + doc_item.uuid + ']'" :value="doc_item.item_code">
                            </template>
                            <template v-else>
                                -
                            </template>
                        </td>
                    </template>
                    <td>@{{ doc_item.line_number }}</td>
                    <td>@{{ doc_item.item_code }}</td>
                    <td>
                        @{{ doc_item.pending_quantity }} /
                        @{{ doc_item.quantity }}
                    </td>
                    <td>@{{ doc_item.unit_price }}</td>
                    <td>-</td>
                </tr>
            @elseif ($action == 'create' || $action == 'edit')
                <tr v-for="doc_item in doc.doc_items" v-if="! doc_item.deleted" :class="{'table-info' : doc_item.editing, 'table-danger' : doc_item.deleting}">
                    <template v-if="doc_item.creating || doc_item.editing">
                        <td>
                            <input type="hidden" id="ref_uuid" name="ref_uuid" v-model="doc_item.ref_uuid">
                            <input type="text" class="form-control form-control-sm line-number" id="line_number" name="line_number" v-model="doc_item.line_number" :class="{'is-invalid': doc_item.errors.hasOwnProperty('line_number')}">
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('line_number')" v-text="doc_item.errors['line_number'][0]"></div>
                        </td>
                        <template v-if="refer">
                            <td>
                                <input type="text" class="form-control-plaintext" :value="doc_item.refer" :readonly="true">
                            </td>
                        </template>
                        <td>
                            <template v-if="refer">
                                <input type="text" class="form-control-plaintext" :value="doc_item.item_code" :readonly="true">
                            </template>
                            <template v-else>
                                <doc-item-code :doc_item="doc_item"></doc-item-code>
                            </template>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" id="quantity" name="quantity" v-model="doc_item.quantity" :class="{'is-invalid': doc_item.errors.hasOwnProperty('quantity')}">
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('quantity')" v-text="doc_item.errors['quantity'][0]"></div>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" id="unit_price" name="unit_price" v-model="doc_item.unit_price" :class="{'is-invalid': doc_item.errors.hasOwnProperty('unit_price')}">
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('unit_price')" v-text="doc_item.errors['unit_price'][0]"></div>
                        </td>
                    </template>
                    <template v-else>
                        <td>@{{ doc_item.line_number }}</td>
                        <td>@{{ doc_item.item_code }}</td>
                        <td>
                            @{{ doc_item.pending_quantity }} /
                            @{{ doc_item.quantity }}
                        </td>
                        <td>@{{ doc_item.unit_price }}</td>
                    </template>

                    <template v-if="doc_item.creating">
                        <td>
                            @if ($action == 'create')
                                <button type="button" class="btn btn-sm btn-outline-danger" @click="doc_item.creating = false; doc_item.deleted = true">delete</button>
                            @elseif ($action == 'edit')
                                <button type="button" class="btn btn-sm btn-outline-info" @click="createDocItem(doc_item)">create</button>

                                <!-- TODO: created value should be reset, when click cancel -->
                                <button type="button" class="btn btn-sm btn-outline-dark" @click="doc_item.deleted = true">cancel</button>
                            @endif

                        </td>
                    </template>

                    <template v-if="doc_item.editing">
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" @click="editDocItem(doc_item)">edit</button>

                            <!-- TODO: edited value should be reset, when click cancel -->
                            <button type="button" class="btn btn-sm btn-outline-dark" @click="doc_item.editing = false">cancel</button>
                        </td>
                    </template>

                    <template v-if="doc_item.deleting">
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" @click="deleteDocItem(doc_item)">delete</button>
                            <button type="button" class="btn btn-sm btn-outline-dark" @click="doc_item.deleting = false">cancel</button>
                        </td>
                    </template>

                    <template v-if="! doc_item.creating && ! doc_item.editing && ! doc_item.deleting">
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" @click="doc_item.editing = true">edit</button>
                            <button type="button" class="btn btn-sm btn-outline-danger" @click="doc_item.deleting = true">delete</button>
                        </td>
                    </template>
                </tr>
            @endif

            @if ($action == 'create' || $action == 'edit')
                <tr>
                    <template v-if="! refer">
                        <td colspan="4"></td>
                        <td><button type="button" class="btn btn-sm btn-outline-success" @click="addDocItemLine()">add</button></td>
                    </template>
                </tr>
            @endif
        </tbody>
    </table>
</doc-item-table>
