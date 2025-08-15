@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('verification_url'))
                        <div class="alert alert-info">
                            <p>For demo purposes, here's your verification link:</p>
                            <a href="{{ session('verification_url') }}" target="_blank">
                                {{ session('verification_url') }}
                            </a>
                            <p class="mt-3">In a real application, this would be sent to your email.</p>
                        </div>
                    @endif

                    <p>Before proceeding, please check your email for a verification link.</p>
                    <p>If you did not receive the email,</p>
                    
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            click here to request another
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection