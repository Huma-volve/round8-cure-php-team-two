@extends('layouts.admin.auth-admin')

@section('title')
    Reset Password
@endsection

@section('content')

    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">

            <!-- Login -->
            <div class="card p-sm-7 p-2">
                <div class="card-body mt-1">
                    <p class="mb-5">Please sign-in to your account and start the adventure</p>
                    <form class="mb-5" action="{{ route('admin.password.reset.update') }}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input
                                    type="hidden"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="{{ $email }}"
                                    />
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
                        <div class="mb-5">
                            <div class="form-password-toggle form-control-validation">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                                type="password"
                                                id="password"
                                                class="form-control"
                                                name="password_confirmation"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password"/>
                                        <label for="password">Confirm Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"
                                    ><i class="icon-base ri ri-eye-off-line icon-20px"></i
                                        ></span>
                                </div>
                                @error('password_confirmation')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
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
