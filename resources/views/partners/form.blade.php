<div class="row">
    <div class="col-md-6 mb-3">
        @if ($action == 'show' || $action == 'edit' || $action == 'delete')
            <input type="text" class="form-control-plaintext" id="subject" name="subject" :value="partner.subject" :readonly="true">
        @elseif ($action == 'create')
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="subject-company" name="subject" v-model="form.subject" value="company"
                class="custom-control-input"
                :class="{'is-invalid': form.errors.has('subject')}"
                @click="subject = 'company'">
            <label class="custom-control-label" for="subject-company">company</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="subject-person" name="subject" v-model="form.subject" value="person"
                class="custom-control-input"
                :class="{'is-invalid': form.errors.has('subject')}"
                @click="subject = 'person'">
            <label class="custom-control-label" for="subject-person">person</label>
            <div class="invalid-feedback" v-if="form.errors.has('subject')" v-text="form.errors.get('subject')"></div>
        </div>
        @endif
    </div>
</div>

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
</div>

<div class="row" v-if="subject == 'company'">
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

<div class="row" v-if="subject == 'person'">
    <div class="col-md-6 mb-3">
        <label for="first_name">{{ __('partners.first_name') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="first_name" name="first_name" :value="partner.first_name" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('first_name')}" id="first_name" name="first_name" value="" v-model="form.first_name">
            <div class="invalid-feedback" v-if="form.errors.has('first_name')" v-text="form.errors.get('first_name')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('first_name')}" id="first_name" name="first_name" value="" v-model="form.first_name">
            <div class="invalid-feedback" v-if="form.errors.has('first_name')" v-text="form.errors.get('first_name')"></div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="last_name">{{ __('partners.last_name') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="last_name" name="last_name" :value="partner.last_name" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('last_name')}" id="last_name" name="last_name" value="" v-model="form.last_name">
            <div class="invalid-feedback" v-if="form.errors.has('last_name')" v-text="form.errors.get('last_name')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('last_name')}" id="last_name" name="last_name" value="" v-model="form.last_name">
            <div class="invalid-feedback" v-if="form.errors.has('last_name')" v-text="form.errors.get('last_name')"></div>
        @endif
    </div>
</div>