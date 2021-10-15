@extends('layouts.app')

@section('content')

    <div class="col-md-12">

            <x-previous-link></x-previous-link>

            <div class="card">
                <div class="card-header">
                    Packages List
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="package-list">Package</label>
                                <select class="form-control select2 px-2" name="package" id="package">
                                    <option>Select</option>
                                    @can('is-admin')
                                        <option value="new_package">-- Create New Package --</option>
                                    @endcan
                                    <optgroup label="Packages">
                                        @if($packages->count() > 0)
                                            @foreach($packages as $id => $package)
                                                <option value={{ $package->id }}>{{ $package->name }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No Packages Available</option>
                                        @endif
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="col-md-12">
                            <div class="packages-container">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/partials/alert-notification.js') }}"></script>
    <script src="{{ asset('js/partials/ajax-response-fail.js') }}"></script>
    <script src="{{ asset('js/partials/ajax-load-view.js') }}"></script>

    {{--  This file loads the Package based on the select2:select event  --}}
    <script src="{{ asset('js/partials/package/load-package-on-select.js') }}"></script>
    <script>
        //load Package on select2
        loadPackageOnSelect();
    </script>
@endsection
