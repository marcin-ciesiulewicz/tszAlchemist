@extends('layouts.app')

@section('content')
    <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        This is a demo project of a CRM system. It only demonstrates parts of functionalities the CRM has.
                    </div>
                </div>
            </div>
@endsection
