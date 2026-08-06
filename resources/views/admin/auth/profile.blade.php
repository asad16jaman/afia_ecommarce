@extends('admin.layouts.master')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('dashboard') }}">Dashboard</a> > Update Profile</span>
            </div>
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-user me-1"></i> Profile Information</div>
                </div>
                <div class="card-body table-card-body">
                    {{-- @if (session('success'))
                        <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif --}}

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ old('phone', $user->phone) }}" required>
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                       

                                        <div class="mb-3 row">
                                            <label for="image" class="col-sm-4 col-form-label">Profile Picture</label>
                                            <div class="col-sm-8">
                                                <input type="file" class="form-control" id="image" name="image">
                                                @if ($user->image)
                                                    <img src="{{asset('uploads/user/'.$user->image) }}" alt="Profile Image" width="100"
                                                        class="mt-2 d-block">
                                                @endif
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update
                                                Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection
