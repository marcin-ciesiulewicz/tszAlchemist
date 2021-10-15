<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorePackageElementRequest;
use App\Http\Traits\StatusHelperClass;
use App\Models\Element;
use App\Models\FieldType;
use App\Models\PackageElement;
use App\Models\TeamworkTaskList;
use App\Models\Unit;
use Gate;
use Illuminate\Support\Facades\Log;

class PackageElementsController extends Controller
{
    private $elements;
    private $units;
    private $field_types;
    private $teamwork_task_list;

    public function __construct()
    {
        $this->elements = Element::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $this->units = Unit::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $this->field_types = FieldType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $this->teamwork_task_list = TeamworkTaskList::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatusHelperClass $statusHelperClass)
    {
        $packageElements = PackageElement::with(['element', 'unit', 'field_type', 'teamwork_task_list'])->get();

        return view('alchemist.package-elements.index', compact('packageElements', 'statusHelperClass'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $elements = $this->elements;
        $units = $this->units;
        $field_types = $this->field_types;
        $teamwork_task_list = $this->teamwork_task_list;

        return view('alchemist.package-elements.create', compact('elements', 'units', 'field_types', 'teamwork_task_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageElementRequest $request)
    {
        $this->authorize('create', PackageElement::class);

        $packageElement = new PackageElement();
        $packageElement->create($request->validated());


        return redirect()->route('package-elements.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, StatusHelperClass $statusHelperClass)
    {
        $elements = $this->elements;
        $units = $this->units;
        $field_types = $this->field_types;
        $teamwork_task_list = $this->teamwork_task_list;
        $packageElement = PackageElement::find($id);

        return view('alchemist.package-elements.edit', compact('packageElement', 'elements', 'units', 'field_types', 'teamwork_task_list', 'statusHelperClass'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PackageElement $packageElement
     * @return \Illuminate\Http\Response
     */
    public function update(StorePackageElementRequest $request, PackageElement $packageElement)
    {

        $this->authorize('update', $packageElement);

        $packageElement->update($request->validated());

        return redirect()->route('package-elements.index')->with('message', "Package Element - `{$packageElement->name}` edited");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PackageElement $packageElement
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageElement $packageElement)
    {
        $this->authorize('delete', $packageElement);

        try {
            $packageElement->delete();
            return redirect()->back()->with('message', "Package Element `{$packageElement->name}` was deleted");

        }catch (\Throwable $t){
            Log::error("[PackageElementController delete] Error occurred trying to delete PackageElement with id {$packageElement->id} Error: ".$t);
            return redirect()->back()->with('error', "Package Element `{$packageElement->name}` could not be deleted. Check log file");

        }


    }
}
