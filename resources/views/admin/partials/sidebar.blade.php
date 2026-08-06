<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            @if (Auth::check())
                <div class="nav">
                    {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                    <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                  

                 

                   

                    

                  

                   

                   

                    


                   


                    

                  

                    


                   

                    

                   

                    


                  

                   

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsecustomer"
                        aria-expanded="{{ Request::is('users*') ? 'true' : 'false' }}" aria-controls="collapsecustomer">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Users
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse {{ Request::is('users*') ? 'show' : '' }}" id="collapsecustomer"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link {{ Request::routeIs('users.create') ? 'active' : '' }}"
                                href="{{ route('users.create') }}">Create User</a>
                            <a class="nav-link {{ Request::routeIs('users.index') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">User List</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseWebContent"
                        aria-expanded="{{ Request::routeIs('setting') ? 'true' : 'false' }}"
                        aria-controls="collapseWebContent">
                        <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                        Settings
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse {{ Request::routeIs('setting') ? 'show' : '' }}" id="collapseWebContent"
                        aria-labelledby="headingWebContent" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link {{ Request::routeIs('setting') ? 'active' : '' }}"
                                href="{{ route('setting') }}">Company Settings</a>
                        </nav>
                    </div>

                </div>
            @endif
        </div>
    </nav>
</div>