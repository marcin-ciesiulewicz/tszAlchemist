<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel='icon'
          href='{{ URL::to('/favicon.ico') }}?v={{ filemtime(realpath(public_path() . '/favicon.ico')) }}'>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet"/>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    {{-- This directive is from tighten/ziggy package, it allows to use route() helper in .js files --}}
    @routes
</head>
<body>

<div id="app">
    @include('layouts.navbar')
    <x-header>{{ str_replace('.', ' ', request()->route()->getName()) }}</x-header>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">

                @if(session('message'))
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                @elseif(session('error'))
                    <div class="col-lg-12">
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    </div>
                @elseif($errors->count() > 0)
                    <div class="col-lg-12">
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </main>
</div>

{{--scripts--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>

<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>

<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script src="{{ asset('js/main.js') }}"></script>

<script src="{{ asset('js/plugins/jquery-validate/jquery.validate.min.js') }}"></script>

<script>
    $('.select2').select2();

    $('.date').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'en',
        icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
        }
    })

    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: 'en',
        sideBySide: true,
        icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
        }
    })

    $('.timepicker').datetimepicker({
        format: 'HH:mm:ss',
        icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
        }
    })
</script>

<script>
    let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
    let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
    let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
    let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
    let printButtonTrans = '{{ trans('global.datatables.print') }}'
    let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
    let selectAllButtonTrans = '{{ trans('global.select_all') }}'
    let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

    let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
    };

    $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {className: 'btn'})
    $.extend($.fn.dataTable.defaults, {
        language: {
            url: languages['{{ app()->getLocale() }}']
        },
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }, {
            orderable: false,
            searchable: false,
            targets: -1
        }],
        select: {
            style: 'multi+shift',
            selector: 'td:first-child'
        },
        order: [],
        scrollX: true,
        pageLength: 100,
        dom: 'lBfrtip<"actions">',
        buttons: [
            {
                extend: 'selectAll',
                className: 'btn-primary',
                text: selectAllButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'selectNone',
                className: 'btn-primary',
                text: selectNoneButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copy',
                className: 'btn-default',
                text: copyButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                className: 'btn-default',
                text: csvButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                className: 'btn-default',
                text: excelButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                className: 'btn-default',
                text: pdfButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                className: 'btn-default',
                text: printButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                className: 'btn-default',
                text: colvisButtonTrans,
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });

    $.fn.dataTable.ext.classes.sPageButton = 'page-item';

</script>

@yield('scripts')
</body>
</html>
