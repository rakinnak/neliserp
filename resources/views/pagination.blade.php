<pagination :dataset="dataset" :appends="{{ isset($appends) ? json_encode($appends) : null }}" @changed="fetch" inline-template>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        {{ __('pagination.from') }} @{{ metaFrom }}
        {{ __('pagination.to') }} @{{ metaTo }},
        {{ __('pagination.total') }} @{{ metaTotal }}.
        <ul class="pagination mb-2 mb-md-0" v-if="hasPagination">
            <li class="page-item" :class="{'disabled': ! prevUrl}">
                <a class="page-link" :href="href(page-1)" @click="page--">&laquo;</a>
            </li>
            <li class="page-item" :class="{'active': p == page}" v-for="p in pages">
                <a class="page-link" :href="href(p)" @click="page = p">@{{ p }}</a>
            </li>
            <li class="page-item" :class="{'disabled': ! nextUrl}">
                <a class="page-link" :href="href(page+1)" @click="page++">&raquo;</a>
            </li>
        </ul>
    </div>
</pagination>