<div class="row">
    <div class="col-md-4 mb-3">
        <label for="company_code">{{ __('docs.company_code') }}</label>
        @if ($action == 'show' || $action == 'delete')
            <input type="text" class="form-control-plaintext" id="company_code" company_code="company_code" :value="doc.company_code" :readonly="true">
        @elseif ($action == 'create' || $action == 'edit')
            <select class="form-control" id="company_uuid" name="company_uuid" v-model="form.company_uuid" :class="{'is-invalid': form.errors.has('company_uuid')}">
                <option value="">-- select --</option>
                <option v-for="company in companies" :value="company.uuid" v-text="company.code"></option>
            </select>
            <div class="invalid-feedback" v-if="form.errors.has('company_uuid')" v-text="form.errors.get('company_uuid')"></div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="name">{{ __('docs.name') }}</label>
        @if ($action == 'show' || $action == 'delete')
            <input type="text" class="form-control-plaintext" id="name" name="name" :value="doc.name" :readonly="true">
        @elseif ($action == 'create' || $action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="issued_at">{{ __('docs.issued_at') }}</label>
        @if ($action == 'show' || $action == 'delete')
            <input type="text" class="form-control-plaintext" id="issued_at" name="issued_at" :value="doc.issued_at" :readonly="true">
        @elseif ($action == 'create' || $action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('issued_at')}" id="issued_at" name="issued_at" value="" v-model="form.issued_at" placeholder="2017-12-04">
            <div class="invalid-feedback" v-if="form.errors.has('issued_at')" v-text="form.errors.get('issued_at')"></div>
        @endif
    </div>
</div>

@if ($action != 'create')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('doc_item.line_number') }}</th>
                <th>{{ __('doc_item.item_code') }}</th>
                <th>{{ __('doc_item.quantity') }}</th>
                <th>{{ __('doc_item.unit_price') }}</th>
                <th>{{ __('doc_item.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if ($action == 'show' || $action == 'delete')
                <tr v-for="doc_item in doc.doc_item" :class="{'table-info' : doc_item.editing, 'table-danger' : doc_item.deleting}">
                    <td>@{{ doc_item.line_number }}</td>
                    <td>@{{ doc_item.item_code }}</td>
                    <td>@{{ doc_item.quantity }}</td>
                    <td>@{{ doc_item.unit_price }}</td>
                    <td>-</td>
                </tr>
            @elseif ($action == 'edit')
                <tr v-for="doc_item in doc.doc_item" v-if="! doc_item.deleted" :class="{'table-info' : doc_item.editing, 'table-danger' : doc_item.deleting}">
                    <template v-if="doc_item.creating || doc_item.editing">
                        <td>
                            <input type="text" class="form-control" id="line_number" name="line_number" v-model="doc_item.line_number" :class="{'is-invalid': doc_item.errors.hasOwnProperty('line_number')}">
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('line_number')" v-text="doc_item.errors['line_number'][0]"></div>
                        </td>
                        <td>
                            <!-- <input type="text" class="form-control" id="item_code" name="item_code" v-model="doc_item.item_code"> -->
                            <!-- :class="{'is-invalid': form.errors.has('company_uuid')}"> -->
                            <select class="form-control" id="item_uuid" name="item_uuid" v-model="doc_item.item_uuid" :class="{'is-invalid': doc_item.errors.hasOwnProperty('item_uuid')}">
                                <option value="">-- select --</option>
                                <option v-for="item in items" :value="item.uuid" v-text="item.code"></option>
                            </select>
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('item_uuid')" v-text="doc_item.errors['item_uuid'][0]"></div>
                        </td>
                        <td>
                            <input type="text" class="form-control" id="quantity" name="quantity" v-model="doc_item.quantity" :class="{'is-invalid': doc_item.errors.hasOwnProperty('quantity')}">
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('quantity')" v-text="doc_item.errors['quantity'][0]"></div>
                        </td>
                        <td>
                            <input type="text" class="form-control" id="unit_price" name="unit_price" v-model="doc_item.unit_price" :class="{'is-invalid': doc_item.errors.hasOwnProperty('unit_price')}">
                            <div class="invalid-feedback" v-if="doc_item.errors.hasOwnProperty('unit_price')" v-text="doc_item.errors['unit_price'][0]"></div>
                        </td>
                    </template>
                    <template v-else>
                        <td>@{{ doc_item.line_number }}</td>
                        <td>@{{ doc_item.item_code }}</td>
                        <td>@{{ doc_item.quantity }}</td>
                        <td>@{{ doc_item.unit_price }}</td>
                    </template>

                    <template v-if="doc_item.creating">
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" @click="createDocItem(doc_item)">create</button>

                            <!-- TODO: created value should be reset, when click cancel -->
                            <button type="button" class="btn btn-sm btn-outline-dark" @click="doc_item.deleted = true">cancel</button>
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

            @if ($action == 'edit')
                <tr>
                    <td colspan="4"></td>
                    <td><button type="button" class="btn btn-sm btn-outline-success" @click="addDocItemLine()">add</button></td>
                </tr>
            @endif
        </tbody>
    </table>
@endif