@extends('layouts.app')

@section('content')

    <div class="col-md-12">

            <x-previous-link></x-previous-link>

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} Package Element
                </div>

                <div class="card-body">
                    <form id="package_element_edit_form" method="POST" action="{{ route("package-elements.update", [$packageElement->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="card card-element-details mb-4">
                            <div class="card-header bg-info text-white">Details</div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $packageElement->name) }}" autocomplete="off" required>
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="required" for="element_id">Element</label>
                                            <select class="form-control select2 {{ $errors->has('element') ? 'is-invalid' : '' }}" name="element_id" id="element_id" required>
                                                @foreach($elements as $id => $element)
                                                    <option value="{{ $id }}" {{ old('element_id', $packageElement->element_id) == $id ? 'selected' : '' }}>{{ $element }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('element'))
                                                <span class="text-danger">{{ $errors->first('element') }}</span>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label class="required" for="unit_id">Unit</label>
                                            <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit_id" id="unit_id" required>
                                                @foreach($units as $id => $unit)
                                                    <option value="{{ $id }}" {{ old('unit_id', $packageElement->unit_id) == $id ? 'selected' : '' }}>{{ $unit }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('unit'))
                                                <span class="text-danger">{{ $errors->first('unit') }}</span>
                                            @endif

                                        </div>

                                        <div class="form-group">
                                            <label for="field_type_id">Field Type</label>
                                            <select class="form-control select2 {{ $errors->has('field_type') ? 'is-invalid' : '' }}" name="field_type_id" id="field_type_id" required>
                                                @foreach($field_types as $id => $field_type)
                                                    <option value="{{ $id }}" {{ old('field_type_id', $packageElement->field_type_id) == $id ? 'selected' : '' }}>{{ $field_type }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('field_type'))
                                                <span class="text-danger">{{ $errors->first('field_type') }}</span>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label for="teamwork_task_list_id">Teamwork Task List</label>
                                            <select class="form-control select2 {{ $errors->has('field_type') ? 'is-invalid' : '' }}" name="teamwork_task_list_id" id="teamwork_task_list_id" required>
                                                @foreach($teamwork_task_list as $id => $task_list)
                                                    <option value="{{ $id }}" {{ old('teamwork_task_list_id', $packageElement->teamwork_task_list_id) == $id ? 'selected' : '' }}>{{ $task_list }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('field_type'))
                                                <span class="text-danger">{{ $errors->first('field_type') }}</span>
                                            @endif

                                        </div>

                                        <div class="form-group">
                                            <label for="status">{{ trans('global.status') }}</label>
                                            <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                                                @foreach($statusHelperClass::getPackageElementStatus() as $id => $packageElementStatus)
                                                    <option value="{{ $id }}" {{ old('status', $packageElement->status) == $id ? 'selected':'' }}>{{ $packageElementStatus }}</option>
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

                        <div class="row">

                            <div class="col-md-6 mb-4">
                                <div class="card card-note">
                                    <div class="card-header bg-info text-white"><label for="notes">Note</label></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" tname="notes" id="notes">{{ old('notes', $packageElement->notes) }}</textarea>
                                                    @if($errors->has('notes'))
                                                        <span class="text-danger">{{ $errors->first('notes') }}</span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-note">
                                    <div class="card-header bg-info text-white"><label for="task_description">Task description</label></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <textarea class="form-control {{ $errors->has('task_description') ? 'is-invalid' : '' }}" name="task_description" id="task_description">{{ old('task_description', $packageElement->task_description) }}</textarea>
                                                    @if($errors->has('task_description'))
                                                        <span class="text-danger">{{ $errors->first('task_description') }}</span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger float-right" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/partials/jq-form-validator.js') }}"></script>
    <script>
        let packageElementFormValidation = jqFormValidator('#package_element_edit_form');

        $('.select2').on('change', function (){
            packageElementFormValidation.element($(this));
        })
    </script>
@endsection
