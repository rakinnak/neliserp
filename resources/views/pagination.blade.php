<pagination :dataset="dataset" @changed="fetch" inline-template>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        {{ __('pagination.from') }} @{{ metaFrom }}
        {{ __('pagination.to') }} @{{ metaTo }},
        {{ __('pagination.total') }} @{{ metaTotal }}.
        <ul class="pagination mb-2 mb-md-0" v-if="hasPagination">
            <li class="page-item" v-if="prevUrl">
                <a class="page-link" href="#" @click="page--">{!! __('pagination.previous') !!}</a>
            </li>
            <!--
            <li class="page-item">
                <a class="page-link" href="#">1</a>
            </li>
            -->
            <li class="page-item" v-if="nextUrl">
                <a class="page-link" href="#" @click="page++">{!! __('pagination.next') !!}</a>
            </li>
        </ul>
    </div>
</pagination>