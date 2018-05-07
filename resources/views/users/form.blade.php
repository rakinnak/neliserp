<div class="row">
    <div class="col-md-6 mb-3">
        <label for="username">{{ __('users.username') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="username" name="username" :value="user.username" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" id="username" name="username" v-model="form.username" :class="{'is-invalid': form.errors.has('username')}">
            <div class="invalid-feedback" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" id="username" name="username" value="" v-model="form.username" :class="{'is-invalid': form.errors.has('username')}">
            <div class="invalid-feedback" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></div>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label for="name">{{ __('users.name') }}</label>
        @if ($action == 'show')
            <input type="text" class="form-control-plaintext" id="name" name="name" :value="user.name" :readonly="true">
        @elseif ($action == 'edit')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @elseif ($action == 'create')
            <input type="text" class="form-control" :class="{'is-invalid': form.errors.has('name')}" id="name" name="name" value="" v-model="form.name">
            <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
        @endif
    </div>
</div>
