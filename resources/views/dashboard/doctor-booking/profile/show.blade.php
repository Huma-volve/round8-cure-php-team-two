@extends('layouts.admin.app')
@section('content')

        <div class="card">
            <div class="card-header">
                <h5>Edit Profile</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('doctor.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('')

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}">
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}">
                    </div>

                    {{-- Hospital --}}
                    <div class="mb-3">
                        <label class="form-label">Hospital Name</label>
                        <input type="text" name="hospital_name" class="form-control"
                            value="{{ old('hospital_name', $doctor->hospital_name) }}">
                    </div>

                    {{-- Location --}}
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location', $doctor->location) }}">
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $doctor->price) }}">
                    </div>

                    {{-- Experience --}}
                    <div class="mb-3">
                        <label class="form-label">Experience Years</label>
                        <input type="number" name="exp_years" class="form-control"
                            value="{{ old('exp_years', $doctor->exp_years) }}">
                    </div>

                    {{-- Bio --}}
                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" rows="4" class="form-control">{{ old('bio', $doctor->bio) }}</textarea>
                    </div>

                    {{-- Image --}}
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $doctor->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$doctor->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-success">Save Changes</button>
                    <a href="{{ route('doctor.profile.show') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    
@endsection