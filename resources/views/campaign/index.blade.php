@extends('layouts.app')
@section('title','Active Campaigns')
@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Active Campaigns
                    <small>
                        @can('is-admin')
                            <a class="btn btn-sm btn-success" href="{{ route("campaigns.create") }}">{{ trans('global.add') }}Campaign</a> &nbsp;
                        @endcan
                    </small>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-Campaign w-100">
                        <thead>
                        <tr>
                            <th width="10">&nbsp;</th>
                            <th>Id</th>
                            <th>Domain</th>
                            <th>Cycle</th>
                            <th>SEO</th>
                            <th class="text-center">Budget <small>($)</small></th>
                            <th>Status</th>
                            <th>Niche</th>
                            <th>Teamwork</th>
                            <th style="min-width: 200px">Tags</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($campaigns as $key => $campaign)
                            <tr data-entry-id="{{ $campaign->id }}">
                                <td></td>
                                <td class="text-sm text-center"><a
                                        href="{{ route('campaigns.show', $campaign->id) }}">{{ $campaign->id ?? '' }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('campaigns.show', $campaign->id) }}">{{ $campaign->domain ?? '' }}</a>
                                    <small> - {{ $campaign->client->name ?? '' }} <sup><a
                                                href="https://{{ $campaign->domain }}/" target="_blank"
                                                rel="nofollow noopener noreferrer"><i class="fas fa-external-link-alt"></i></a></sup></small>
                                </td>
                                <td class="text-sm text-center">
                                    @if ($campaign->cycle === $statusHelperClass::CYCLE_MID)
                                        <span class="bg-info">MID</span>
                                    @elseif($campaign->cycle === $statusHelperClass::CYCLE_END)
                                        <span class="bg-success">END</span>
                                    @else
                                        <span class="bg-secondary">OTO</span>
                                    @endif
                                </td>
                                <td><small><i class="fa fa-users"></i> {{ $campaign->manager_seo->name ?? '' }}</small></td>
                                <td class="text-center">{{ $campaign->budget ?? '' }}</td>
                                <td class="text-sm text-center">
                                    <span class="bg-info">{{ $statusHelperClass::getCampaignsStatuses()[$campaign->status] }}</span>
                                </td>
                                <td class="text-center">
                                    {{ $campaign->niche->name ?? '' }}
                                </td>
                                <td class="text-center">
                                    {!! $campaign->teamwork_id ? '<a href="#" class="teamwork_link" rel="nofollow noopener noreferrer" target="_blank">'.$campaign->teamwork_id.'</a>':'' !!}
                                </td>
                                <td class="text-sm position-relative tag-td" data-campaign-id="{{ $campaign->id }}" style="min-width:200px;">
                                    <div class="tag-container-{{ $campaign->id }}">
                                        @include('tag.index')
                                    </div>
                                </td>
                                <td>

                                    @can('is-admin')
                                        <a class="btn btn-sm btn-primary" href="{{ route('campaigns.edit', $campaign->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('is-admin')
                                        <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                              style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-danger"
                                                   value="{{ trans('global.delete') }}">
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
    <script src="{{ asset('js/partials/alert-notification.js') }}"></script>
    <script src="{{ asset('js/partials/ajax-response-fail.js') }}"></script>
    <script src="{{ asset('js/partials/ajax-load-view.js') }}"></script>
    <script src="{{ asset('js/partials/tag/tag.js') }}"></script>
    <script>

        $('.teamwork_link').on('click', function (e){
            e.preventDefault();
           alert('Demo project. No connection to Teamwork site');
        });

        //---datatable
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
            order: [[1, 'asc']],
            pageLength: 10,
        });
        $('.datatable-Campaign:not(.ajaxTable)').DataTable({buttons: dtButtons})
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    </script>
@endsection
