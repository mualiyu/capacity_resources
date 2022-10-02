@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
        
                            {{ __('You are logged in!') }}
                        </div>
                    </div><br><br>
                    <div class="row">
                        <form action="{{route('upload_excel')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <label for="excel" class="col-md-3 col-form-label text-md-end">{{ __('Resources') }}</label>
    
                                <div class="col-md-7">
                                    <input id="excel" type="file" class="form-control @error('excel') is-invalid @enderror" name="resource_excel" required>
    
                                    @error('resource_excel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row mb-0 m-3">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Add resources') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
