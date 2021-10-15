@extends('layouts.ajax')

@section('content')

    <div class="card">
        <div class="card-header" style="background-color: rgba(0,0,0,.03)"><b>Add Package</b></div>
        <div class="card-body">

            <form id="add-package-form" action="{{ route('packages.store') }}" method="POST"
                  enctype="multipart/form-data">
                <fieldset @cannot('is-admin') disabled @endcan>
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-md-3">
                            <label for="package_name">Package Name</label>
                            <input class="form-control mb-4" type="text" name="package_name" id="package_name"
                                   placeholder="Package Name" value="{{ $package->name }}" required>

                            <label for="package_status">Status</label>
                            <select name="package_status" id="package_status" class="form-control">
                                @foreach($statusHelperClass::getPackageStatus() as $id => $packageStatus)
                                    <option
                                        value="{{ $id }}" {{ $package->status == $id ? 'selected':'' }}>{{ $packageStatus }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-9">
                            <div class="card">

                                <div class="row">

                                    <div class="card-header col-2 bg-success text-white"
                                         style="max-width: 60px !important;text-orientation: upright;writing-mode: vertical-lr;">
                                        1st Month
                                    </div>

                                    <div class="card-body col-10 mx-auto">

                                        <div class="table-responsive table-first-month">
                                            <table class="table table-sm">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th width="10">

                                                    </th>
                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Unit
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($firstMonthPackageElements as $element)

                                                    <tr data-entry-id="{{ $element->id }}">
                                                        <td>
                                                            {{ $element->name ?? '' }}
                                                        </td>
                                                        <td>
                                                            <input class="select_first_month"
                                                                   name="select_first_month_{{$element->id}}"
                                                                   id="select_first_month_{{$element->id}}"
                                                                   type="checkbox"
                                                                   data-element-id="{{ $element->id }}"
                                                                   data-element-name="{{ $element->name }}"
                                                                   data-element-field-type="{{ $element->field_type->id }}"
                                                                   data-first-month-package-to-element-id="{{ $element->package_to_element->pluck('id')->first() }}"
                                                                   @if($element->package_to_element->isNotEmpty()) checked @endif>
                                                        </td>
                                                        <td width="180">
                                                            {!! $element->field_type->id === $statusHelperClass::PACKAGE_FIELD_BIANRY ? '<input style="width:18px;height:18px;" type="checkbox" checked disabled>' : '<input class="form-control input-sm amount_first_month noscroll" type="number" name="amount" data-element-id="'.$element->id.'" id="amount_first_month_'.$element->id.'" value="'.$element->package_to_element->pluck('amount')->first().'" min="0">' !!}
                                                        </td>
                                                        <td>
                                                            {{ $element->unit->name }}
                                                        </td>

                                                    </tr>
                                                    <input type="hidden"
                                                           name="first_month_package_to_element_id_{{ $element->id }}"
                                                           id="first_month_package_to_element_id_{{ $element->id }}"
                                                           value="{{ $element->package_to_element->pluck('id')->first() }}">
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <br>
                            <div class="card">

                                <div class="row">

                                    <div class="card-header col-2 bg-info text-white"
                                         style="max-width: 60px !important;text-orientation: upright;writing-mode: vertical-lr;">
                                        Rolling from 2nd Month
                                    </div>

                                    <div class="card-body col-10 mx-auto">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th width="10">

                                                    </th>
                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Unit
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($secondMonthPackageElements as $element)
                                                    <tr data-entry-id="{{ $element->id }}">
                                                        <td>
                                                            {{ $element->name ?? '' }}
                                                        </td>
                                                        <td>
                                                            <input class="select_from_second_month"
                                                                   name="select_from_second_month_{{$element->id}}"
                                                                   id="select_from_second_month_{{$element->id}}"
                                                                   type="checkbox"
                                                                   data-element-id="{{ $element->id }}"
                                                                   data-element-name="{{ $element->name }}"
                                                                   data-element-field-type="{{ $element->field_type->id }}"
                                                                   data-second-month-package-to-element-id="{{ $element->package_to_element->pluck('id')->first() }}"
                                                                   @if($element->package_to_element->isNotEmpty()) checked @endif>
                                                        </td>
                                                        <td width="180">
                                                            {!! $element->field_type->id === $statusHelperClass::PACKAGE_FIELD_BIANRY ? '<input style="width:18px;height:18px;" type="checkbox" checked disabled>':'<input class="form-control input-sm amount_second_month noscorll" type="number" name="amount" data-element-id="'.$element->id.'" id="amount_second_month_'.$element->id.'" value="'.$element->package_to_element->pluck('amount')->first().'" min="0">' !!}
                                                        </td>
                                                        <td>
                                                            {{ $element->element->name }}
                                                        </td>
                                                        <td>
                                                            {{ $element->unit->name }}
                                                        </td>
                                                        <td>
                                                            <select
                                                                name="second_month_package_frequency_{{ $element->id }}"
                                                                id="second_month_package_frequency_{{ $element->id }}"
                                                                class="form-control input-sm">
                                                                @foreach($packageFrequency as $id => $frequency)
                                                                    <option
                                                                        value="{{ $id }}" {{ $element->package_to_element->pluck('frequency')->first() == $id ? 'selected':'' }} >{{ $frequency }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="package_note">Notes</label>
                                <textarea class="form-control" name="package_note" id="package_note" cols="5"
                                          rows="2">{{ $package->notes }}</textarea>
                            </div>

                            <div class="float-right">
                                @can('is-admin')
                                    <button class="btn btn-danger store-package" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                @endcan
                            </div>

                        </div>

                        <div class="col-md-9 offset-md-3 mt-3 package-notification">
                        </div>

                    </div>
                </fieldset>
            </form>


        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/partials/alert-notification.js') }}"></script>
    <script src="{{ asset('js/partials/validate-input.js') }}"></script>
    <script src="{{ asset('js/partials/package/mark-package-element.js') }}"></script>
    <script src="{{ asset('js/partials/package/get-data-for-given-month.js') }}"></script>
    <script src="{{ asset('js/partials/package/ajax-store-package.js') }}"></script>
    <script>

        //---if it's campaign create page disable package editing
        if ($('#is_campaign_page').val() == 1) {
            $('#add-package-form fieldset').attr('disabled', 'disabled');
            $('.store-package').hide();
        }

        //mark first month elements
        markPackageElement('amount_first_month', 'select_first_month_');

        //mark first month elements
        markPackageElement('amount_second_month', 'select_from_second_month_');

        $('.store-package').on('click', function (e) {

            e.preventDefault();

            let packageName = $('#package_name').val(),
                packageNote = $('#package_note').val(),
                packageStatus = $('#package_status').find(':selected').val(),
                nameInputSelector = $('#package_name'),
                packageId = {{ $package->id }},
                url = route('packages.update', packageId),
                firstMonthElement = $('.select_first_month'),
                secondMonthElement = $('.select_from_second_month'),
                notificationElement = $('.package-notification'),

                //Get data for the first month and second month
                firstMonthData = getDataForGivenMonth(firstMonthElement, 'amount_first_month_'),
                secondMonthData = getDataForGivenMonth(secondMonthElement, 'amount_second_month_', 'second_month_package_frequency_'),

                //data object to send in ajax
                dataObject = {
                    name: packageName,
                    firstMonth: firstMonthData.packageElementsObject,
                    secondMonth: secondMonthData.packageElementsObject,
                    notes: packageNote,
                    status: packageStatus
                };

            //validate data
            if (!validateInput(nameInputSelector)) {
                return false;
            }

            if (!firstMonthData.amountToValidate || !secondMonthData.amountToValidate) {
                return false;
            }

            if (jQuery.isEmptyObject(firstMonthData.packageElementsObject)) {
                notificationElement.html('');
                notificationElement.append(alertNotification('danger', 'Add 1st Month Package Elements')).hide().fadeIn("slow");
            } else {

                notificationElement.html('');

                //update package
                ajaxStorePackage('PUT', url, dataObject, notificationElement);

            }

        });
    </script>
@endsection
