<div class="row mb-1">
    <div class="col-md-12">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">{{ trans('global.back') }}</a>
        {{ $slot }}
    </div>
</div>
