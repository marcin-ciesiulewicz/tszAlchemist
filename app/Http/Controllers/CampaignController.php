<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Traits\StatusHelperClass;
use App\Jobs\teamworkCreateCompany;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Campaign;
use App\Models\Tag;
use App\Models\Niche;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatusHelperClass $statusHelperClass)
    {

        $campaigns = Campaign::where('status', $statusHelperClass::CAMPAIGN_ACTIVE)->with(['tags','client', 'manager_seo', 'currency'])->get();

        $tags = Tag::all();

        return view('campaign.index', compact('campaigns', 'tags', 'statusHelperClass'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StatusHelperClass $statusHelperClass)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');
        $clients = Company::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $manager_seos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $manager_technicals = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currencies = Currency::all()->pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $niches = Niche::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $packages = Package::where('status', $statusHelperClass::PACKAGE_STATUS_ACTIVE)->get();

        return view('campaign.create', compact( 'packages' ,'clients', 'manager_seos', 'manager_technicals', 'currencies', 'niches', 'statusHelperClass'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRequest $request)
    {

        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');

        try {
            $campaign = Campaign::create($request->validated());
            if ($request->create_teamwork_project === 'on'){

//            $creatorEmail = Auth::user()->email;
//                Demo Project,jobs not dispatching
//                teamworkCreateCompany::dispatch($request->validated(), $campaign, $creatorEmail);
            }
            return redirect()->route('campaigns.index')->with(['message'=>"Campaign Added. Adding projects to Teamwork disabled"]);
        }catch (\Throwable $t){
            app('log')->error('While Saving the campaign error occurred '. $t);
            return redirect()->back()->withErrors(['Error', 'Saving Campaign Failed. Check the log file']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign, StatusHelperClass $statusHelperClass)
    {
        $campaign->load('client', 'manager_seo', 'currency', 'niche');

        return view('campaign.show', compact('campaign', 'statusHelperClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, StatusHelperClass $statusHelperClass)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');

        $manager_seos = User::all()->pluck('name', 'id');

        $manager_technicals = User::all()->pluck('name', 'id');

        $campaign->load('client', 'manager_seo', 'currency', 'niche');

        $packages = Package::where('status', $statusHelperClass::PACKAGE_STATUS_ACTIVE)->get();

        return view('campaign.edit', compact( 'packages' , 'manager_seos', 'manager_technicals', 'campaign', 'statusHelperClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');
        //budget value is calculated in CampaignObserver
        $campaign->update($request->validated());

        return redirect()->back()->with(['message'=>"Campaign {$campaign->domain} updated"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');
        $campaign->tags()->detach();
        $campaign->delete();

        return redirect()->route('campaigns.index')->with(['message' => "Campaign {$campaign->domain} deleted "]);
    }
}
