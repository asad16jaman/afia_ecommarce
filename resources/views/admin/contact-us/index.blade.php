@extends('admin.layouts.master')

@section('title', 'All Contact Inquiries')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Contact Inquiries
                </span>
            </div>

            <!-- Contact Us List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-envelope me-1"></i>Contact Inquiries</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Country</th>
                                <th>Source</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactUs as $key => $contact)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $contact->name }}</td>
                                    <td class="align-middle">{{ $contact->email }}</td>
                                    <td class="align-middle">{{ $contact->phone ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $contact->company_name ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $contact->country ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $contact->source ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $contact->subject }}</td>
                                    <td class="align-middle">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#messageModal{{ $contact->id }}">
                                            View Message
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="messageModal{{ $contact->id }}" tabindex="-1"
                                            aria-labelledby="messageModalLabel{{ $contact->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="messageModalLabel{{ $contact->id }}">
                                                            Message from {{ $contact->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        {{ $contact->message }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td class="align-middle">{{ Str::limit($contact->message, 50) }}</td> --}}
                                    {{-- <td class="align-middle">
                                        @if ($contact->attachment)
                                            <a href="{{ asset('admin/files/' . $contact->attachment) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-paperclip"></i> View
                                            </a>
                                        @else
                                            <span class="text-muted">No File</span>
                                        @endif
                                    </td> --}}
                                    <td class="align-middle">{{ $contact->created_at->format('d M Y') }}</td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('contact-us.destroy', $contact->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete show-confirm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
