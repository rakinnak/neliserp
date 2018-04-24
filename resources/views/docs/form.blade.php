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
