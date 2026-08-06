@extends('admin.layouts.master')
@section('title', 'Edit User')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> > Edit
                    User</span>
            </div>
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-user-edit me-1"></i> Edit User</div>
                    <a href="{{ route('users.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        {{-- @if (session('success'))
                            <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif --}}
                        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Name -->
                                <div class="form-group row">
                                    <label for="name" class="col-sm-1 col-form-label">Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="name"
                                            name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <label for="email" class="col-sm-1 col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="email" class="form-control form-control-sm" id="email"
                                            name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- User Name -->
                                    <label for="username" class="col-sm-1 col-form-label">User Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="username"
                                            name="username" value="{{ old('username', $user->username) }}">
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- <!-- Address -->
                                    <label for="address" class="col-sm-1 col-form-label">Address</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="address"
                                            name="address" value="{{ old('address', $user->address) }}">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <!-- Phone -->
                                    <label for="phone" class="col-sm-1 col-form-label">Phone</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="phone"
                                            name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- User Type -->
                                    <label for="type" class="col-sm-1 col-form-label">User Type</label>
                                    <div class="col-sm-3">
                                        <select name="type" class="form-control form-control-sm" id="type" required>
                                            <option value="admin"
                                                {{ old('type', $user->type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="user"
                                                {{ old('type', $user->type) == 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Profile Picture -->
                                <label for="image" class="col-sm-1 col-form-label"
                                    style="margin-left: -9px;">Image</label>
                                <div class="col-sm-3">
                                    <div class="d-flex align-items-center">
                                        <img id="imagePreview" src="{{ asset('uploads/user/'.$user->image) }}"
                                            alt="Profile Picture Preview" width="50" class="me-2">
                                        <input type="file" class="form-control form-control-sm" id="image"
                                            name="image" onchange="previewImage(event)">
                                        <!-- Tooltip icon -->
                                        <span class="info-tooltip ms-2" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="JPG/JPEG/PNG • Max: 2MB">
                                            ?
                                        </span>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                
                                </div>
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <label for="password" class="col-sm-1 col-form-label">Password</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control form-control-sm" id="password"
                                        name="password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <label for="password_confirmation" class="col-sm-1 col-form-label"
                                    style="margin-left: -9px;">C-Password</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control form-control-sm" id="password_confirmation"
                                        name="password_confirmation">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                
                            </div>

                            <hr class="my-2">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
