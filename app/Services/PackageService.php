<?php

namespace App\Services;

use App\Http\Traits\StatusHelperClass;
use App\Models\Package;
use App\Models\PackageElement;
use App\Models\PackageToElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageService
{

    /**
     * @param Request $request
     * @param Package|null $package
     * @return array|string[]
     */
    public function storePackage(Request $request, ?Package $package): array
    {
        if (!$package){
            $package = new Package();
        }

        $firstMonthToSync = [];
        $secondMonthToSync = [];

        foreach ($request->firstMonth as $first) {
            $firstMonthToSync[$first['elementId']] = [
                'amount' => $first['elementAmount'], 'is_first_month' => 1,
            ];
        }

        if (!empty($request->secondMonth)) {
            foreach ($request->secondMonth as $second) {
                $secondMonthToSync[$second['elementId']] = [
                    'amount' => $second['elementAmount'], 'frequency' => $second['packageFrequency'], 'is_first_month' => 0,
                ];
            }
        }

        DB::beginTransaction();

        try {

            $package->name = $request->name;
            $package->status = $request->status ?? StatusHelperClass::PACKAGE_STATUS_ACTIVE;
            $package->notes = $request->notes;
            $package->save();

            //delete corresponding package to elements before attaching them again
            PackageToElement::where('package_id', $package->id)->delete();

            $package->package_element()->attach($firstMonthToSync);
            $package->package_element()->attach($secondMonthToSync);

            DB::commit();

            $status = ['status' => 'success', 'packageId' => $package->id];

        } catch (\Throwable $t) {

            $status = ['status' => 'error'];

            app('log')->error($t);

            DB::rollBack();

        }
        return $status;
    }


    /**
     * @param Package $package
     * @param int $month
     * @return mixed
     */
    public function loadPackageToElements(Package $package, int $month)
    {
        return PackageElement::where('status', \App\Http\Traits\StatusHelperClass::PACKAGE_ELEMENT_STATUS_ACTIVE)->with([
            'package_to_element' => function ($query) use ($package, $month) {
                $query->where('is_first_month', '=', $month)->where('package_id', $package->id);
            },
            'element', 'unit', 'field_type'
        ])->orderBy('name', 'asc')->get();

    }

}
