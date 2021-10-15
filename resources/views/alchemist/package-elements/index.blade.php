@extends('layouts.app')
@section('title', 'Package Elements')
@section('content')

    <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4>Package Element List
                        <small>
                            @can('create', \App\Models\PackageElement::class)
                                <a class="btn btn-sm btn-success" href="{{ route("package-elements.create") }}">
                                    {{ trans('global.add') }} Package Element
                                </a>
                            @endcan
                        </small>
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable datatable-Packagist w-100">
                            <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Element
                                </th>
                                <th>
                                    Unit
                                </th>
                                <th>
                                    Field Type
                                </th>
                                <th>
                                    Teamwork Task List
                                </th>
                                <th>
                                    Notes
                                </th>
                                <th>
                                    Task Description
                                </th>
                                <th>

                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($packageElements as $key => $element)
                                <tr data-entry-id="{{ $element->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $element->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $statusHelperClass::getPackageElementStatus()[$element->status] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $element->element->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $element->unit->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $element->field_type->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $element->teamwork_task_list->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $element->notes ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $element->task_description ?? '-' }}
                                    </td>
                                    <td>

                                        @can('update', $element)
                                            <a class="btn btn-sm btn-info" href="{{ route('package-elements.edit', $element->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('delete', $element)
                                            <form action="{{ route('package-elements.destroy', $element->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan

                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

@endsection

@section('scripts')
<script>
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    $.extend(true, $.fn.dataTable.defaults, {
        order: [[ 1, 'desc' ]],
        pageLength: 10,
    });
    $('.datatable-Packagist:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
</script>
@endsection
