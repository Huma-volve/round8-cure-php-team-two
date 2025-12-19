
@extends('layouts.admin.auth-admin')

@section('title')
    Login
@endsection

@section('content')

    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">

            <!-- Login -->
            <div class="card p-sm-7 p-2">
                <div class="card-body mt-1">
                    <p class="mb-5">Please sign-in to your account and start the adventure</p>
                    <form class="mb-5" action="{{ route('admin.login.check') }}" method="POST">

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
                            <div class="form-password-toggle form-control-validation">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                                type="password"
                                                id="password"
                                                class="form-control"
                                                name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password"/>
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"
                                    ><i class="icon-base ri ri-eye-off-line icon-20px"></i
                                        ></span>
                                </div>
                                @error('password')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                            <div class="form-check mb-0">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember-me"/>
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                            <a href="{{ route('admin.password.reset.show.email') }}" class="float-end mb-1">
                                <span>Forgot Password?</span>
                            </a>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit">login</button>
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
