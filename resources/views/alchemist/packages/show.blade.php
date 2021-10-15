@extends('layouts.ajax')

@section('content')
    <div class="card">
        <div class="card-header" style="background-color: rgba(0,0,0,.03)"><b>Package</b></div>
        <div class="card-body">

            <form>
                <fieldset disabled>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="package_name">Package Name</label>
                            <input class="form-control mb-4" type="text" name="package_name" id="package_name"
                                   placeholder="Package Name" value="{{ $package->name }}" required>

                            <label for="package_status">Status</label>
                            <select name="package_status" id="package_status" class="form-control">
                                @foreach($statusHelperClass::getPackageStatus() as $id => $packageStatus)
                                    <option value="{{ $id }}" {{ $package->status == $id ? 'selected':'' }}>{{ $packageStatus }}</option>
                                @endforeach
                            </select>

                            @if($package->niche_id != null)
                                <div class="form-group">
                                    <label for="niche">Select Niche</label>
                                    <select class="form-control select2" name="proposal_niche" id="proposal_niche" required>
                                        <option value="">Select Niche</option>
                                        @foreach($niches as $id => $niche)
                                            <option value="{{ $niche->id }}" data-niche-tag="{{ $nicheTags[$niche->isPremium] ?? 'Green' }}" {{ $package->niche_id == $niche->id ? 'selected':'' }}>{{ $niche->name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="niche-notification"></div>
                                </div>
                            @endif

                        </div>

                        <div class="col-md-9">
                            <div class="card">

                                <div class="row">

                                    <div class="card-header col-2 bg-success"
                                         style="max-width: 60px !important;text-orientation: upright;writing-mode: vertical-lr;">
                                        1st Month
                                    </div>

                                    <div class="card-body col-10 mx-auto">

                                        <div class="table-responsive table-first-month">
                                            <table class="table table-sm">
                                                <thead>
                                                <tr>
                                                    <th width="10">

                                                    </th>
                                                    <th>
                                                        Name
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
                                                @foreach($firstMonthPackageElements as $id => $element)
                                                    @if($element->package_to_element->isNotEmpty())
                                                        <tr data-entry-id="{{ $element->id }}">

                                                            <td>
                                                                <input class="select_first_month"
                                                                       name="select_first_month_{{$id}}"
                                                                       id="select_first_month_{{$id}}" type="checkbox"
                                                                       data-element-id="{{ $element->id }}"
                                                                       data-element-name="{{ $element->name }}"
                                                                       data-element-field-type="{{ $element->field_type->id }}"
                                                                       data-first-month-package-to-element-id="{{ $element->package_to_element->pluck('id')->first() }}"
                                                                       @if($element->package_to_element->isNotEmpty()) checked @endif>
                                                            </td>
                                                            <td>
                                                                {{ $element->name ?? '' }}
                                                            </td>
                                                            <td width="150">
                                                                {!! $element->field_type->id === $statusHelperClass::PACKAGE_FIELD_BIANRY ? '<input style="width:18px;height:18px;" type="checkbox" checked disabled>' : '<input class="form-control input-sm amount noscroll" type="number" name="amount" id="amount_first_month_'.$id.'" value="'.$element->package_to_element->pluck('amount')->first().'" min="0">' !!}
                                                            </td>
                                                            <td>
                                                                {{ $element->unit->name }}
                                                            </td>

                                                        </tr>
                                                        <input type="hidden"
                                                               name="first_month_package_to_element_id_{{ $id }}"
                                                               id="first_month_package_to_element_id_{{ $id }}"
                                                               value="{{ $element->package_to_element->pluck('id')->first() }}">
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <br>

                            <div class="card mb-4">

                                <div class="row">

                                    <div class="card-header col-2 bg-info"
                                         style="max-width: 60px !important;text-orientation: upright;writing-mode: vertical-lr;">
                                        2nd Rolling
                                    </div>

                                    <div class="card-body col-10 mx-auto">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                <tr>
                                                    <th width="10">

                                                    </th>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th>
                                                        Quantity
                                                    </th>
                                                    <th>
                                                        Unit
                                                    </th>
                                                    <th width="180">
                                                        Frequency
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($secondMonthPackageElements as $id => $element)
                                                    @if($element->package_to_element->isNotEmpty())
                                                        <tr data-entry-id="{{ $element->id }}">
                                                            <td>
                                                                <input class="select_from_second_month"
                                                                       name="select_from_second_month_{{$id}}"
                                                                       id="select_from_second_month_{{$id}}"
                                                                       type="checkbox"
                                                                       data-element-id="{{ $element->id }}"
                                                                       data-element-name="{{ $element->name }}"
                                                                       data-element-field-type="{{ $element->field_type->id }}"
                                                                       data-second-month-package-to-element-id="{{ $element->package_to_element->pluck('id')->first() }}"
                                                                       @if($element->package_to_element->isNotEmpty()) checked @endif>
                                                            </td>
                                                            <td>
                                                                {{ $element->name ?? '' }}
                                                            </td>
                                                            <td width="150">
                                                                {!! $element->field_type->id === $statusHelperClass::PACKAGE_FIELD_BIANRY ? '<input style="width:18px;height:18px;" type="checkbox" checked disabled>':'<input class="form-control input-sm amount noscorll" type="number" name="amount" id="amount_second_month_'.$id.'" value="'.$element->package_to_element->pluck('amount')->first().'" min="0">' !!}
                                                            </td>
                                                            <td>
                                                                {{ $element->unit->name }}
                                                            </td>
                                                            <td>
                                                                <select name="second_month_package_frequency_{{ $id }}"
                                                                        id="second_month_package_frequency_{{ $id }}"
                                                                        class="form-control input-sm">
                                                                    @foreach($statusHelperClass::getPackageFrequency() as $id => $frequency)
                                                                        <option value="{{ $id }}" {{ $element->package_to_element->pluck('frequency')->first() == $id ? 'selected':'' }} >{{ $frequency }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold" for="package_note">Notes</label>
                                <textarea class="form-control" name="package_note" id="package_note" cols="5"
                                          rows="2">{{ $package->notes }}</textarea>
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

@section('scripts')@endsection
