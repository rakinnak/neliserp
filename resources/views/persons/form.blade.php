<div class="row">
    <div class="col-md-6 mb-3">
        <label for="code">{{ __('partners.code') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="code" name="code" :value="partner.code" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" id="code" name="code" v-model="form.code" :class="{'is-invalid': form.errors.has('code')}">
            <div class="invalid-feedback" v-if="form.errors.has('code')" v-text="form.errors.get('code')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" id="code" name="code" value="" v-model="form.code" :class="{'is-invalid': form.errors.has('code')}">
            <div class="invalid-feedback" v-if="form.errors.has('code')" v-text="form.errors.get('code')"></div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="name">{{ __('partners.name') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="name" name="name" :value="partner.name" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @endif
    </div>
</div>
