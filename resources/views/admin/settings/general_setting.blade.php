@extends('admin.layouts.master')

@section('title', 'General Settings')
@section('main-content')

    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-cogs"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Settings</span>
            </div>
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-cog me-1"></i>General Settings</div>
                </div>
                <div class="card-body table-card-body">
                    <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Company Name -->
                            <label for="name" class="col-sm-1 col-form-label">Name</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="name"
                                    name="name" value="{{ old('name', $setting->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Address -->
                            <label for="address" class="col-sm-1 col-form-label">Address</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="address"
                                    name="address" value="{{ old('address', $setting->address) }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Phone -->
                            <label for="phone" class="col-sm-1 col-form-label">Phone</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="phone"
                                    name="phone" value="{{ old('phone', $setting->phone) }}"
                                    required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        
                            <!-- Company Email -->
                            <label for="email" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control form-control-sm" id="email"
                                    name="email" value="{{ old('email', $setting->email) }}"
                                    required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                      
                            <!-- Facebook URL -->
                            <label for="facebook_url" class="col-sm-1 col-form-label">Facebook</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="facebook_url"
                                    name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}">
                                @error('facebook_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                           

                            <!-- LinkedIn URL -->
                            <label for="linkedin_url" class="col-sm-1 col-form-label">LinkedIn</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="linkedin_url"
                                    name="linkedin_url" value="{{ old('linkedin_url', $setting->linkedin_url) }}">
                                @error('linkedin_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        
                            <!-- Youtube URL -->
                            <label for="website_url" class="col-sm-1 col-form-label">Web Url</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="website_url"
                                    name="website_url" value="{{ old('website_url', $setting->website_url) }}">
                                @error('website_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 

                             <label for="youtube_url" class="col-sm-1 col-form-label">Youtube</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="youtube_url"
                                    name="youtube_url" value="{{ old('youtube_url', $setting->youtube_url) }}">
                                @error('youtube_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> 

                            <label for="total_workforce" class="col-sm-1 col-form-label">T.Workforce</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="total_workforce"
                                    name="total_workforce" value="{{ old('total_workforce', optional($setting)->total_workforce) }}">
                                @error('total_workforce')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Favicon Image -->
                            <label for="favicon_image" class="col-sm-1 col-form-label">Favicon</label>
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <img id="faviconPreview"
                                        src="{{ $setting->favicon_image ? asset('uploads/logo_and_icon/' . $setting->favicon_image) : asset('uploads/no_images/no-image.png') }}"
                                        alt="Favicon Preview" width="50" class="me-2">
                                    <input type="file" class="form-control form-control-sm" id="favicon_image"
                                        name="favicon_image" onchange="previewImage(event, 'faviconPreview')">
                                </div>
                                @error('favicon_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        
                            <!-- Company Logo -->
                            <label for="logo" class="col-sm-1 col-form-label">Logo</label>
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <img id="logoPreview"
                                        src="{{ $setting->logo ? asset('uploads/logo_and_icon/' . $setting->logo) : asset('uploads/no_images/no-image.png') }}"
                                        alt="Company Logo Preview" width="50" class="me-2">
                                    <input type="file" class="form-control form-control-sm" id="logo"
                                        name="logo" onchange="previewImage(event, 'logoPreview')">
                                </div>
                                @error('logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="heritage" class="col-sm-1 col-form-label">Heritage</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="heritage"
                                    name="heritage" value="{{ old('heritage', optional($setting)->heritage) }}">
                                @error('heritage')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                             <label for="production_capacity" class="col-sm-1 col-form-label">Production C.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="production_capacity"
                                    name="production_capacity" value="{{ old('production_capacity', optional($setting)->production_capacity) }}">
                                @error('production_capacity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            

                            <label for="total_projects" class="col-sm-1 col-form-label">T.Projects</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="total_projects"
                                    name="total_projects" value="{{ old('total_projects', optional($setting)->total_projects) }}">
                                @error('total_projects')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                             <label for="video" class="col-sm-1 col-form-label">Video</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="video"
                                    name="video" placeholder="Youtube Video" value="{{ old('video', optional($setting)->video) }}">
                                @error('video')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Google Map -->
                            <label for="google_map" class="col-sm-1 col-form-label">Google Map</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="google_map"
                                    name="google_map" value="{{ old('google_map', $setting->google_map) }}">
                                @error('google_map')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            
                            <!-- footer_short_description -->
                            <label for="footer_short_description" class="col-sm-1 col-form-label">Footer T.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="footer_short_description"
                                    name="footer_short_description" value="{{ old('footer_short_description', $setting->footer_short_description) }}" required>
                                @error('footer_short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- PDF -->
                            <label for="file" class="col-sm-1 col-form-label">File</label>
                            <div class="col-sm-3">
                                <div class="">
                                    <input type="file" class="form-control form-control-sm" id="file" name="file" accept=".pdf">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-danger">PDF file Only</p>
                                        @if($setting->file)
                                             <div>
                                                <a href="{{ asset('uploads/logo_and_icon/'.$setting->file) }}" class="btn btn-info btn-sm p-1 text-white" target="_blank">View</a>
                                             </div>
                                        @endif
                                    </div>
                                </div>
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        
                            <!-- Thum File -->
                            <label for="file_thum" class="col-sm-1 col-form-label">File Thum</label>
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <img id="logoPreview3"
                                        src="{{ $setting->file_thum ? asset('uploads/logo_and_icon/' . $setting->file_thum) : asset('uploads/no_images/no-image.png') }}"
                                        alt="Company Logo Preview" width="50" class="me-2">
                                    <input type="file" class="form-control form-control-sm" id="file_thum"
                                        name="file_thum" onchange="previewImage(event, 'logoPreview3')">
                                        
                                </div>
                                <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative;">
                                                JPG/JPEG/PNG • Max: 2MB • 500×400px
                                            </span>
                                        </small>
                                @error('file_thum')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Google Map -->
                            <label for="file_title" class="col-sm-1 col-form-label">File Title</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="file_title"
                                    name="file_title" value="{{ old('google_map', $setting->file_title) }}">
                                @error('file_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                                           
                        </div>
                        <hr class="my-2">
                        <div class="clearfix">
                            <div class="text-end m-auto">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save
                                    Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById(previewId);
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

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
