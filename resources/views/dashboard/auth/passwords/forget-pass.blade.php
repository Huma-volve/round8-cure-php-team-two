
@extends('layouts.admin.auth-admin')

@section('title')
    Forget Password
@endsection

@section('content')

    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">

            <!-- Login -->
            <div class="card p-sm-7 p-2">
                <div class="card-body mt-1">
                    <p class="mb-5">Please sign-in to your account and start the adventure</p>
                    <form class="mb-5" action="{{ route('admin.password.send.otp') }}" method="POST">

                        @csrf
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    autofocus/>
                            <label for="email">Email </label>
                            @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit">Send</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /Login -->

            <img src="{{ asset('assets/admin/img/illustrations/tree-3.png') }}"
                 alt="auth-tree"
                 class="authentication-image-object-left d-none d-lg-block"/>

            <img src="{{ asset('assets/admin/img/illustrations/auth-basic-mask-light.png') }}"
                 class="authentication-image d-none d-lg-block scaleX-n1-rtl"
                 height="172"
                 alt="triangle-bg"/>

            <img src="{{ asset('assets/admin/img/illustrations/tree.png') }}"
                 alt="auth-tree"
                 class="authentication-image-object-right d-none d-lg-block"/>

        </div>
    </div>
@endsection
