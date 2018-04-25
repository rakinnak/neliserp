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

<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('doc_item.line_number') }}</th>
            <th>{{ __('doc_item.item_code') }}</th>
            <th>{{ __('doc_item.quantity') }}</th>
            <th>{{ __('doc_item.unit_price') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($action == 'show' || $action == 'delete')
            <tr v-for="doc_item in doc.doc_item">
                <td>@{{ doc_item.line_number }}</td>
                <td>@{{ doc_item.item_code }}</td>
                <td>@{{ doc_item.quantity }}</td>
                <td>@{{ doc_item.unit_price }}</td>
            </tr>
        @elseif ($action == 'create')
            <tr>
                <td>
                    <input type="text" class="form-control" id="line_number" name="line_number">
                </td>
                <td>
                    <input type="text" class="form-control" id="item_code" name="item_code">
                </td>
                <td>
                    <input type="text" class="form-control" id="quantity" name="quantity">
                </td>
                <td>
                    <input type="text" class="form-control" id="unit_price" name="unit_price">
                </td>
            </tr>
        @elseif ($action == 'edit')
            <tr v-for="doc_item in doc.doc_item">
                <td>
                    <input type="text" class="form-control" id="line_number" name="line_number" :value="doc_item.line_number">
                </td>
                <td>
                    <input type="text" class="form-control" id="item_code" name="item_code" :value="doc_item.item_code">
                </td>
                <td>
                    <input type="text" class="form-control" id="quantity" name="quantity" :value="doc_item.quantity">
                </td>
                <td>
                    <input type="text" class="form-control" id="unit_price" name="unit_price" :value="doc_item.unit_price">
                </td>
            </tr>
        @endif
    </tbody>
</table>