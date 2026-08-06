@extends('admin.layouts.master')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('dashboard') }}">Dashboard</a> > Change Password</span>
            </div>
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-key me-1"></i> Password Information</div>
                </div>
                <div class="card-body table-card-body">
                    {{-- @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif --}}

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <label for="current_password" class="col-sm-4 col-form-label">Current
                                                Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" required>
                                                @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="new_password" class="col-sm-4 col-form-label">New Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" required>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="new_password_confirmation" class="col-sm-4 col-form-label">Confirm
                                                New Password</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" id="new_password_confirmation"
                                                    name="new_password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update
                                                Password</button>
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
@endsection
