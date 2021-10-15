@extends('layouts.app')
@section('title', 'Campaign Details: ' . $campaign->domain)
@section('content')

    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h2 class="text-center">
                    <b>{{ $campaign->client->name ?? '-' }} - {{ $campaign->domain ?? '-' }}</b>
                    <i class="fas fa-comment-dollar" style="font-size: 1.5rem;"
                       title="Payment Date: {{ $campaign->payment_date }}"></i>
                    <br>
                    <span style="font-size: 1.2rem;">Start Date: {{ $campaign->start_date }}</span>
                </h2>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 mb-4">

                        <div class="card">

                            <div class="card-body">
                                <x-previous-link>
                                    <a class="btn btn-sm btn-dark" href="{{ route('campaigns.edit', $campaign->id ) }}">{{ trans('global.edit') }} Campaign</a>
                                </x-previous-link>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">

                        <div class="row">
                            <div class=" col-md-3">
                                <div class="card">
                                    <div class="card-header text-center" style="background-color: rgba(0,0,0,.03);">
                                <span>
                                    {{ trans('global.campaign.cycle') }}
                                </span>
                                    </div>
                                    <div class="card-body text-center">
                                <span>
                                    @if( $campaign->cycle === $statusHelperClass::CYCLE_MID)
                                        <span class="bg-info">MID</span>
                                    @elseif($campaign->cycle === $statusHelperClass::CYCLE_END)
                                        <span class="bg-success">END</span>
                                    @else
                                        <span class="bg-secondary">OTO</span>
                                    @endif
                                </span>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-md-3">
                                <div class="card">
                                    <div class="card-header text-center" style="background-color: rgba(0,0,0,.03);;">
                                <span>
                                    {{ trans('global.status') }}
                                </span>
                                    </div>
                                    <div class="card-body text-center">
                                        @if($campaign->status == $statusHelperClass::CAMPAIGN_INACTIVE)
                                            <i class="fa fa-times-circle text-danger"></i> <span class="text-danger text-bold">Campaign {{ $statusHelperClass::getCampaignsStatuses()[$campaign->status] }} ! </span>
                                        @elseif($campaign->status == $statusHelperClass::CAMPAIGN_SUSPENDED)
                                            <i class="fa fa-exclamation-triangle text-warning"></i> <span
                                                class="text-warning text-bold">Campaign {{ $statusHelperClass::getCampaignsStatuses()[$campaign->status] }} ! </span>
                                        @else
                                            <i class="fa fa-check-circle text-success"></i> <span
                                                class="text-success text-bold">{{ $statusHelperClass::getCampaignsStatuses()[$campaign->status] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class=" col-md-3">
                                <div class="card">
                                    <div class="card-header text-center" style="background-color: rgba(0,0,0,.03);;">
                                        <span>
                                            {{ trans('global.campaign.niche') }}
                                        </span>
                                    </div>
                                    <div class="card-body text-center">
                                        <span>
                                            {{ $campaign->niche->name ?? '(not set)' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-md-3">
                                <div class="card">
                                    <div class="card-header text-center" style="background-color: rgba(0,0,0,.03);;">
                            <span>
                                Teamwork ID
                            </span>
                                    </div>
                                    <div class="card-body text-center">
                            <span>
                                {!! $campaign->teamwork_id ? '<a href="https://seoagency.teamwork.com/#/projects/'.$campaign->teamwork_id.'/overview/activity" target="_blank" rel="nofollow noopener noreferrer">'.$campaign->teamwork_id.'</a>':'-' !!}
                            </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="card">
                                    <div class="card-header" style="background-color: rgba(0,0,0,.03);;">
                                <span>
                                    {{ trans('global.description') }}
                                </span>
                                    </div>
                                    <div class="card-body">
                                <span>
                                    {!! $campaign->description !!}
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-3 mb-4">
                        <div class="card">
                            <div class="card-header text-center" style="background-color: rgba(0,0,0,.05);;">
                        <span>
                            <i class="fa fa-donate"></i>
                            {{ trans('global.campaign.budget') }}
                        </span>
                            </div>
                            <div class="card-body text-center">
                        <span>
                            <b>$ {{ $campaign->budget }}</b>
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 mb-4">
                        <div class="card">
                            <div class="card-header text-center" style="background-color: rgba(0,0,0,.05);;">
                        <span>
                            <i class="fa fa-money-bill-wave"></i>
                            {{ trans('global.campaign.budget_real') }}
                        </span>
                            </div>
                            <div class="card-body text-center">
                        <span>
                            <b>{{ $campaign->budget_real }} {{ $campaign->currency->code }}</b>
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 mb-4">
                        <div class="card">
                            <div class="card-header text-center" style="background-color: rgba(0,0,0,.05);;"><i
                                    class="fa fa-users"></i> {{ trans('global.campaign.manager_seo') }}
                            </div>
                            <div class="card-body text-center">
                                @if(is_null($campaign->manager_seo_id))
                                    <b>{{ trans('global.campaign.manager_seo') }} not assigned</b>
                                @else
                                    @if(count(\App\Models\User::where('id',$campaign->manager_seo_id)->whereNull('deleted_at')->pluck('name')) > 0)
                                        <b>{{ $campaign->manager_seo->name }}</b>
                                    @else
                                        <b>{{ \App\Models\User::withTrashed()->where('id',$campaign->manager_seo_id)->pluck('name')->first() }}
                                            - this Manager/User was deleted!</b>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3 mb-4">
                        <div class="card">
                            <div class="card-header text-center" style="background-color: rgba(0,0,0,.05);;"><i
                                    class="fa fa-cogs"></i> {{ trans('global.campaign.manager_technical') }}
                            </div>
                            <div class="card-body text-center">
                                @if(is_null($campaign->manager_technical_id))
                                    <b>{{ trans('global.campaign.manager_technical') }} not assigned</b>
                                @else
                                    @if(count(\App\Models\User::where('id',$campaign->manager_technical_id)->whereNull('deleted_at')->pluck('name')) > 0)
                                        <b>{{ $campaign->manager_technical->name }}</b>
                                    @else
                                        <b>{{ \App\Models\User::withTrashed()->where('id',$campaign->manager_technical_id)->pluck('name')->first() }}
                                            - this Manager/User was deleted!</b>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="accordion" id="accordionCampaignPackage">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed text-decoration-none" type="button" data-toggle="collapse"
                                                data-target="#collapseNine" aria-expanded="false"
                                                aria-controls="collapseOne">
                                            <i class="fas fa-box-open"></i>
                                            <b>Package Details</b>
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseNine" class="collapse" aria-labelledby="headingNine"
                                     data-parent="#accordionCampaignPackage">
                                    <div class="card-body">
                                        <input type="hidden" name="is_campaign_page" id="is_campaign_page" value="1">
                                        <input type="hidden" name="package_id" id="package_id"
                                               value="{{ $campaign->package_id }}">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="packages-container">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
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

    {{--  This file loads the Package assigned to a campaign on document.ready  --}}
    <script src="{{ asset('js/partials/package/load-package-on-ready.js') }}"></script>
    <script>

        //load Package on document.ready
        loadPackageOnReady();

        //---datatable
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
            order: [[1, 'asc']],
            pageLength: 10,
        });
        $('.datatable-ReportedLinks:not(.ajaxTable)').DataTable({buttons: dtButtons})
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    </script>
@endsection
