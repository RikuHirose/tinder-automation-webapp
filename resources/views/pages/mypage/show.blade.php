@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <swipe-tinder-button
                    :user-id="{{ json_encode(auth()->user()->id) }}"
                    ></swipe-tinder-button>

                    <integrate-tinder-button
                    :user-id="{{ json_encode(auth()->user()->id) }}"
                    ></integrate-tinder-button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
