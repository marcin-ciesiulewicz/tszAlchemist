@extends('layouts.app')
@section('title', 'Campaign Edit')
@section('content')

    <div class="col-md-12">

        <x-previous-link></x-previous-link>

        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} Campaign
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("campaigns.update", [$campaign->id]) }}" enctype="multipart/form-data"  id="edit_campaign_form">
                    @method('PUT')
                    @csrf

                    <div class="card mb-4">

                        <div class="card-header bg-info">
                            Client Info
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label class="required" for="company_id">{{ trans('global.campaign.client') }}</label>
                                        <input class="form-control form-control-sm" type="text" name="campaign_company" id="campaign_company" value="{{ $campaign->client->name }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="domain">{{ trans('global.campaign.domain') }}</label>
                                        <input class="form-control form-control-sm" type="text" name="campaign_domain" id="campaign_domain" value="{{ $campaign->domain }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="cycle">{{ trans('global.campaign.cycle') }}</label>

                                        <select class="form-control form-control-sm {{ $errors->has('cycle') ? 'is-invalid':'' }}" name="cycle" id="select-cycle" required>
                                            @foreach($statusHelperClass::getCampaignsCycles() as $id => $cycle)
                                                <option value="{{ $id }}" {{ $campaign->cycle == $id ? 'selected':'' }}>{{ $cycle }}</option>
                                            @endforeach

                                        </select>

                                        @if($errors->has('cycle'))
                                            <span class="text-danger">{{ $errors->first('cycle') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="description">{{ trans('global.description') }}</label>
                                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $campaign->description) }}</textarea>
                                        @if($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card mb-4">

                        <div class="card-header bg-info">
                            Agency Info
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label class="required" for="budget">{{ trans('global.campaign.budget') }}</label>
                                         <input class="form-control form-control-sm" type="text" name="campaign_budget" id="campaign_budget" value="$ {{ $campaign->budget }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="budget_real">{{ trans('global.campaign.budget_real') }}</label>
                                        <input class="form-control form-control-sm" type="number" name="campaign_budget_real" id="campaign_budget_real" value="{{ $campaign->budget_real }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="currency_id">{{ trans('global.campaign.currency') }}</label>
                                        <input class="form-control form-control-sm" type="text" name="campaign_currency" id="campaign_currency" value="{{ $campaign->currency->symbol }}" readonly>
                                        @if($errors->has('currency_id'))
                                            <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_date">{{ trans('global.campaign.payment_date') }}</label>
                                        <input class="form-control form-control-sm" type="text" name="campaign_payment_date" id="campaign_payment_date" value="{{ $campaign->payment_date }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">{{ trans('global.campaign.start_date') }}</label>
                                        <input class="form-control form-control-sm" type="text" name="campaign_start_date" id="campaign_start_date" value="{{ $campaign->start_date }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="niche_id">{{ trans('global.campaign.niche') }}</label>
                                        <input class="form-control form-control-sm" name="campaign_niche_name" id="campaign_niche_name" value="{{ $campaign->niche->name }}" readonly>
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label for="manager_seo_id">{{ trans('global.campaign.manager_seo') }}</label>
                                        <select class="form-control select2 {{ $errors->has('manager_seo') ? 'is-invalid' : '' }}" name="manager_seo_id" id="manager_seo_id">
                                            @foreach($manager_seos as $id => $manager_seo)
                                                <option value="{{ $id }}" {{ $campaign->manager_seo_id == $id ? 'selected' : '' }}>{{ $manager_seo }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('manager_seo_id'))
                                            <span class="text-danger">{{ $errors->first('manager_seo_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="manager-technical-id">{{ trans('global.campaign.manager_technical') }}</label>
                                        <select class="form-control select2 {{ $errors->has('manager_technical') ? 'is-invalid' : '' }}" name="manager_technical_id" id="manager-technical-id">
                                            @foreach($manager_technicals as $id => $manager_technical)
                                                <option value="{{ $id }}" {{ $campaign->manager_technical_id == $id ? 'selected' : '' }}>{{ $manager_technical }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('manager_technical_id'))
                                            <span class="text-danger">{{ $errors->first('manager_technical_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="status">{{ trans('global.status') }}</label>

                                        <select class="form-control form-control-sm {{ $errors->has('status') ? 'is-invalid':'' }}" name="status" id="select-status" required>

                                            @foreach($statusHelperClass::getCampaignsStatuses() as $id => $status)
                                                <option value="{{ $id }}" {{ $campaign->status == $id ? 'selected':'' }}>{{ $status }}</option>
                                            @endforeach

                                        </select>

                                        @if($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Teamwork Details --}}
                    <div class="card card-teamwork-details mb-4">
                        <div class="card-header bg-info">Teamwork Details</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="teamwork_id">Teamwork ID</label>
                                        <input class="form-control form-control-sm" type="number" name="teamwork_id" id="teamwork_id" value="{{ $campaign->teamwork_id ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Package --}}
                    <div class="card mb-4">
                        <div class="card-header bg-info">Package</div>
                        <div class="card-body">
                            <input type="hidden" name="is_campaign_page" id="is_campaign_page" value="1">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="package-list">Package</label>
                                        <select class="form-control select2 px-2" name="package" id="package">
                                            <option value="">Select</option>
                                            <option value="new_package">-- Create New Package --</option>
                                            <optgroup label="Packages">
                                                @foreach($packages->where('is_proposal', '==', null) as $id => $package)
                                                    <option value={{ $package->id }} {{ $campaign->package_id == $package->id ? 'selected':'' }}>{{ $package->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                </div>

                                <div class="col-md-4">

                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="packages-container">

                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="package_id" id="package_id" value="{{ $campaign->package_id }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger update-campaign float-right" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script src="{{ asset('js/partials/alert-notification.js') }}"></script>
    <script src="{{ asset('js/partials/ajax-response-fail.js') }}"></script>
    <script src="{{ asset('js/partials/ajax-load-view.js') }}"></script>
    <script src="{{ asset('js/partials/jq-form-validator.js') }}"></script>

    {{--  This file loads the Package assigned to a campaign on document.ready  --}}
    <script src="{{ asset('js/partials/package/load-package-on-ready.js') }}"></script>

    {{--  This file loads the Package based on the select2:select event  --}}
    <script src="{{ asset('js/partials/package/load-package-on-select.js') }}"></script>
    <script>

        //validate form
        let formValidation = jqFormValidator('#edit_campaign_form');
        $('.select2').on('change', function (e){
            formValidation.element($(this));
        });

        //load Package on document.ready
        loadPackageOnReady();
        //load Package on select2:select
        loadPackageOnSelect();

        $('.update-campaign').on('click', function (e){

            if(formValidation.form()){
                if($('#package').find(':selected').val() != 'new_package'){
                    $('#package_id').val($('#package').find(':selected').val());
                }else {
                    e.preventDefault();
                    $('.store-package').click();
                }
            }

        });

    </script>
@endsection
