<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequest;
use App\Http\Traits\StatusHelperClass;
use App\Models\Package;
use App\Models\PackageElement;
use App\Services\PackageService;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('name')->get();

        return view('alchemist.packages.index', compact('packages'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StatusHelperClass $statusHelperClass, Request $request)
    {

        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');

        $packageElements = PackageElement::where('status', $statusHelperClass::PACKAGE_STATUS_ACTIVE)->orderBy('name', 'asc')->get();
        $packageElements->load('unit');

        return view('alchemist.packages.create', compact('packageElements', 'statusHelperClass'));

    }

    /**
     * @param StorePackageRequest $request
     * @param PackageService $packageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePackageRequest $request, PackageService $packageService)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access Denied');
        $packageStatus = $packageService->storePackage($request, null);

        return response()->json($packageStatus);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package, PackageService $packageService, StatusHelperClass $statusHelperClass)
    {
        $package->load('package_to_element');
        $firstMonthPackageElements = $packageService->loadPackageToElements($package, $statusHelperClass::PACKAGE_ELEMENT_FIRST_MONTH);
        $secondMonthPackageElements = $packageService->loadPackageToElements($package, $statusHelperClass::PACKAGE_ELEMENT_SECOND_MONTH);

        return view('alchemist.packages.show', compact('package', 'firstMonthPackageElements', 'secondMonthPackageElements', 'statusHelperClass'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package, PackageService $packageService, StatusHelperClass $statusHelperClass)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access Denied');

        $package->load('package_to_element');
        $firstMonthPackageElements = $packageService->loadPackageToElements($package, $statusHelperClass::PACKAGE_ELEMENT_FIRST_MONTH);
        $secondMonthPackageElements = $packageService->loadPackageToElements($package, $statusHelperClass::PACKAGE_ELEMENT_SECOND_MONTH);
        $packageFrequency = $statusHelperClass::getPackageFrequency();

        return view('alchemist.packages.edit', compact('package', 'firstMonthPackageElements', 'secondMonthPackageElements', 'packageFrequency', 'statusHelperClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(StorePackageRequest $request, Package $package, PackageService $packageService)
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access Denied');

        $packageStatus = $packageService->storePackage($request, $package);

        return response()->json($packageStatus);
    }

}
