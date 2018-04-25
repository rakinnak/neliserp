<div class="row">
    <div class="col-md-6 mb-3">
        <label for="company_code">{{ __('docs.company_code') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="company_code" company_code="company_code" :value="doc.company_code" :readonly="true">
        @elseif ($action == 'delete')
            <input type="text" class="form-control-plaintext" id="company_code" company_code="company_code" :value="doc.company_code" :readonly="true">
        @elseif ($action == 'edit')
            <select class="form-control" id="company_uuid" name="company_uuid" v-model="form.company_uuid" :class="{'is-invalid': form.errors.has('company_uuid')}">
                <option value="">-- select --</option>
                <option v-for="company in companies" :value="company.uuid" v-text="company.code"></option>
            </select>
            <div class="invalid-feedback" v-if="form.errors.has('company_uuid')" v-text="form.errors.get('company_uuid')"></div>
        @elseif ($action == 'create')
            <select class="form-control" id="company_uuid" name="company_uuid" v-model="form.company_uuid" :class="{'is-invalid': form.errors.has('company_uuid')}">
                <option value="">-- select --</option>
                <option v-for="company in companies" :value="company.uuid" v-text="company.code"></option>
            </select>
            <div class="invalid-feedback" v-if="form.errors.has('company_uuid')" v-text="form.errors.get('company_uuid')"></div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name">{{ __('docs.name') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="name" name="name" :value="doc.name" :readonly="true">
        @elseif ($action == 'delete')
            <input type="text" class="form-control-plaintext" id="name" name="name" :value="doc.name" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="issued_at">{{ __('docs.issued_at') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="issued_at" name="issued_at" :value="doc.issued_at" :readonly="true">
        @elseif ($action == 'delete')
            <input type="text" class="form-control-plaintext" id="issued_at" name="issued_at" :value="doc.issued_at" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('issued_at')}" id="issued_at" name="issued_at" value="" v-model="form.issued_at" placeholder="2017-12-04">
            <div class="invalid-feedback" v-if="form.errors.has('issued_at')" v-text="form.errors.get('issued_at')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('issued_at')}" id="issued_at" name="issued_at" value="" v-model="form.issued_at" placeholder="2017-12-04">
            <div class="invalid-feedback" v-if="form.errors.has('issued_at')" v-text="form.errors.get('issued_at')"></div>
        @endif
    </div>
</div>