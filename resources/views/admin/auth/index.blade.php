@extends('admin.layouts.master')

@section('title', 'User List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > User List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-users me-1"></i> User List
                    </div>
                    <a href="{{ route('users.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>

                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($user->image)
                                            <img src="{{ asset('uploads/user/'.$user->image) }}" alt="User Image"
                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-left: 11px;">
                                        @else
                                            <img src="{{ asset('uploads/no_images/no-image.png') }}" alt="User Image"
                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-left: 11px;">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ ucfirst($user->type) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('users.updateStatus', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $user->status == 'a' ? 'p' : ($user->status == 'p' ? 'd' : 'a') }}">

                                            <button type="submit"
                                                class="btn btn-sm
                                                                    {{ $user->status == 'a' ? 'btn-success' : ($user->status == 'p' ? 'btn-warning' : 'btn-danger') }}"
                                                style="padding: 2px 10px; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 7px;">

                                                @if ($user->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($user->status == 'p')
                                                    <i class="fas fa-clock"></i> Pending
                                                @else
                                                    <i class="fas fa-ban"></i> Deactivated
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit"
                                                title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            {{-- @if ($user->type !== 'admin')
                                                <button type="button" class="btn btn-warning btn-sm access-btn"
                                                    style="font-size: 0.5rem;" data-bs-toggle="modal"
                                                    data-bs-target="#accessModal{{ $user->id }}" title="Manage Access">
                                                    <i class="fas fa-user-edit fa-sm"></i>
                                                </button>
                                            @endif --}}

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="m-0 p-0 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- User Access Modal -->
                                <div class="modal fade" id="accessModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="accessModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div
                                                class="modal-header d-flex justify-content-between align-items-center py-2 px-3">
                                                <h4 class="modal-title font-weight-bold mb-0" style="font-size: 1.25rem;">
                                                    User Access</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('user.access.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                    <div class="form-group">
                                                        
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary bg-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
