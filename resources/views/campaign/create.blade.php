@extends('layouts.app')
@section('title', 'Campaign Create')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                {{ trans('global.create') }} Campaign
            </div>

            <div class="card-body">

                <form id="create_campaign_form" method="POST" action="{{ route("campaigns.store") }}" enctype="multipart/form-data">
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
                                        <select class="form-control select2 {{ $errors->has('client') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                                            @foreach($clients as $id => $client)
                                                <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>{{ $client }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('company_id'))
                                            <span class="text-danger">{{ $errors->first('company_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="domain">{{ trans('global.campaign.domain') }}</label>
                                        <input class="form-control {{ $errors->has('domain') ? 'is-invalid' : '' }}" type="text" name="domain" id="domain" value="{{ old('domain', '') }}" required>
                                        @if($errors->has('domain'))
                                            <span class="text-danger">{{ $errors->first('domain') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="cycle">{{ trans('global.campaign.cycle') }}</label>
                                        <select class="form-control {{ $errors->has('cycle') ? 'is-invalid' : '' }}" name="cycle" id="cycle" required>
                                            <option value selected>Please Select</option>
                                            @foreach($statusHelperClass::getCampaignsCycles() as $id => $cycle)
                                                <option value="{{ $id }}" {{ old('$cycle') == $id ? 'selected':'' }}>{{ $cycle }}</option>
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
                                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
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
                                        <label class="required" for="budget_real">{{ trans('global.campaign.budget_real') }}</label>
                                        <input class="form-control {{ $errors->has('budget_real') ? 'is-invalid' : '' }}" type="number" name="budget_real" id="budget_real" value="{{ old('budget_real') }}" step="0.01" required>
                                        @if($errors->has('budget_real'))
                                            <span class="text-danger">{{ $errors->first('budget_real') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="currency_id">{{ trans('global.campaign.currency') }}</label>
                                        <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency_id" id="currency_id" required>
                                            @foreach($currencies as $id => $currency)
                                                <option value="{{ $id }}">{{ $currency }} </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('currency_id'))
                                            <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_date">{{ trans('global.campaign.payment_date') }}</label>
                                        <input class="form-control date {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" required>
                                        @if($errors->has('payment_date'))
                                            <span class="text-danger">{{ $errors->first('payment_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">{{ trans('global.campaign.start_date') }}</label>
                                        <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                                        @if($errors->has('start_date'))
                                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="niche_id">{{ trans('global.campaign.niche') }}</label>
                                        <select class="form-control select2 {{ $errors->has('niche') ? 'is-invalid' : '' }}" name="niche_id" id="niche_id" required>
                                            @foreach($niches as $id => $niche)
                                                <option value="{{ $id }}" {{ old('niche_id') == $id ? 'selected' : '' }}>{{ $niche }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('niche_id'))
                                            <span class="text-danger">{{ $errors->first('niche_id') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label for="manager_seo_id">{{ trans('global.campaign.manager_seo') }}</label>
                                        <select class="form-control select2 {{ $errors->has('manager_seo') ? 'is-invalid' : '' }}" name="manager_seo_id" id="manager_seo_id" required>
                                            @foreach($manager_seos as $id => $manager_seo)
                                                <option value="{{ $id }}" {{ old('manager_seo_id') == $id ? 'selected' : '' }}>{{ $manager_seo }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('manager_seo_id'))
                                            <span class="text-danger">{{ $errors->first('manager_seo_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="manager-technical-id">Manager Technical</label>
                                        <select class="form-control select2 {{ $errors->has('manager_technical') ? 'is-invalid' : '' }}" name="manager_technical_id" id="manager-technical-id" required>
                                            @foreach($manager_technicals as $id => $manager_technical)
                                                <option value="{{ $id }}" {{ old('manager_technical_id') == $id ? 'selected' : '' }}>{{ $manager_technical}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('manager_technical_id'))
                                            <span class="text-danger">{{ $errors->first('manager_technical_id') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-info">
                            Invite Users
                        </div>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="invite_people">Who would you like to invite</label>

                                    <div class="users-to-invite">
                                        <div class="row user-to-invite-details">
                                            <div class="form-group col-md-4">
                                                <span class="span-icon">
                                                    <i class="fas fa-user-edit" aria-hidden="true"></i>
                                                </span>
                                                <input class="form-control form-control-sm input-padding first_name" type="text"
                                                       name="first_name[]" placeholder="First Name">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <span class="span-icon">
                                                    <i class="fas fa-user-tag" aria-hidden="true"></i>
                                                </span>
                                                <input class="form-control form-control-sm input-padding last_name" type="text"
                                                       name="last_name[]" placeholder="Last Name">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <span class="span-icon">
                                                    <i class="fas fa-envelope-open-text" aria-hidden="true"></i>
                                                </span>
                                                <input class="form-control form-control-sm input-padding email" type="email"
                                                       name="email[]" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <a href="#" class="btn-custom-round" id="add_user_to_invite" title="Add Field"><i class="fas fa-plus"></i></a>
                                            <a href="#" class="btn-custom-round" id="remove_user_to_invite" title="Remove Field"><i class="fas fa-minus"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                    {{-- Package accordion --}}
                    <div class="card mb-4">
                        <div class="card-header bg-info">Select Package</div>
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
                                                    <option value={{ $package->id }}>{{ $package->name }}</option>
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
                        </div>
                        <input type="hidden" name="package_id" id="package_id" value="">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="create_teamwork_project" id="create_teamwork_project" checked> <label for="create_teamwork_project">"Also Create a Project in Teamwork"</label>

                        <div class="card card-teamwork-details mb-4">
                            <div class="card-header bg-info">Teamwork Details</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="teamwork_id">Teamwork ID</label>
                                            <input class="form-control" type="number" name="teamwork_id" id="teamworkid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger create-campaign float-right" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>

                    <div class="niche-notification"></div>
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
    <script src="{{ asset('js/partials/validate-input.js') }}"></script>
    <script src="{{ asset('js/partials/jq-form-validator.js') }}"></script>

    <script src="{{ asset('js/partials/campaign/invite-users.js') }}"></script>
    <script src="{{ asset('js/partials/campaign/validate-invited-users-form.js') }}"></script>

    {{--  This file loads the Package based on the select2:select event  --}}
    <script src="{{ asset('js/partials/package/load-package-on-select.js') }}"></script>
    <script>

        loadPackageOnSelect();

        //validate form
        let formValidation = jqFormValidator('#create_campaign_form');
        $('.select2').on('change', function() {
            formValidation.element($(this));
        });

        //---store/show edit campaign
        $('.card-teamwork-details').hide();

        $('#create_teamwork_project').on('change', function (){
            $('.card-teamwork-details').toggle();
        });

        $('.create-campaign').on('click', function (e){

            if (formValidation.form()){
                //validate users to invite
                validateInvitedUsersForm(e);

                if($('#package').find(':selected').val() != 'new_package'){
                    $('#package_id').val($('#package').find(':selected').val());
                }else{
                    e.preventDefault();
                    $('.store-package').click();
                }

            }

        });

    </script>
@endsection
