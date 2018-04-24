<table class="table table-bordered table-hover">
    <thead class="thead-light">
        {{ $thead }}
    </thead>
    <tbody>
        <tr v-if="! done">
            <td colspan="2">
                <i class="fa fa-spinner fa-spin"></i> {{ __('loading') }}
            </td>
        </tr>
        <tr v-if="done && items.length == 0">
            <td colspan="2">
                not found
            </td>
        </tr>
        {{ $tbody }}
    </tbody>
</table>
