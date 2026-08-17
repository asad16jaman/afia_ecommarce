<style>
:root {
    --base-color: #F85606;
    --sidebar-width: 100%;
    --sidebar-bg: #ffffff;
    --sidebar-border: #e5e5e5;
    --sidebar-text: #444;
    --sidebar-muted: #999;
    --sidebar-hover: #f5f4f2;
    --sidebar-active-bg: #fff3ed;
    --sidebar-radius: 5px;
}

.dash-shell {
    width: 100%;
    display: flex;
    align-items: stretch;
    background: #f5f4f0;
}
.dash-sidebar {
    width: var(--sidebar-width);
    min-width: var(--sidebar-width);
    height: 100%;
    min-height: 420px;
    background: var(--nav-color);
    border-right: 1px solid var(--sidebar-border);
    display: flex;
    flex-direction: column;
    position: sticky;
    top: 0;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 100;
    scrollbar-width: thin;
    scrollbar-color: #ddd transparent;
}
.dash-sidebar::-webkit-scrollbar {
    width: 3px;
}
.dash-sidebar::-webkit-scrollbar-track {
    background: transparent;
}
.dash-sidebar::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 10px;
}
.sb-user {
    min-height: 52px;
    padding: 7px 10px;
    display: flex;
    align-items: center;
    gap: 9px;
    border-bottom: 1px solid var(--sidebar-border);
}
.sb-avatar {
    width: 35px;
    height: 35px;
    min-width: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--base-color);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    line-height: 1;
}
.sb-name {
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sb-sub {
    color: #fff;
    font-size: 10px;
    line-height: 1.3;
    margin-top: 1px;
    white-space: nowrap;
}
.dash-sidebar nav {
    width: 100%;
}
/* Section Label */
.sb-label {
    padding: 7px 10px 4px;
    color: #aaa;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    line-height: 1.3;
}
.sb-group {
    width: 100%;
    border-bottom: 1px solid var(--sidebar-border);
}
.sb-link {
    width: 100%;
    min-height: 33px;
    padding: 6px 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 5px;
    color: #fff;
    background: transparent;
    border: 0;
    border-left: 3px solid transparent;
    border-bottom: 1px solid #ededed;
    text-decoration: none !important;
    font-size: 12.5px;
    font-weight: 500;
    line-height: 1.3;
    box-sizing: border-box;
    transition:
        background .13s ease,
        color .13s ease,
        border-color .13s ease;
}
.sb-group .sb-link:last-child {
    border-bottom: none;
}
.sb-link:hover {
    background: var(--sidebar-hover);
    color: #222;
    text-decoration: none !important;
}
.sb-link.active {
    color: var(--color-second);
    background: #fff;
    border-left-color: var(--color-second);
    font-weight: 700;
}
.sb-link-l {
    display: flex;
    align-items: center;
    gap: 9px;
    min-width: 0;
    white-space: nowrap;
}
.sb-link-l i {
    width: 15px;
    min-width: 15px;
    text-align: center;
    font-size: 13px;
    color: #fff;
    line-height: 1;
}

.sb-link:hover .sb-link-l i {
    color: #000;
}
.sb-link.active .sb-link-l i {
    color: var(--base-color);
}

.sb-badge {
    min-width: 18px;
    height: 18px;
    padding: 1px 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ededed;
    color: var(--nav-color);
    border-radius: 10px;
    font-size: 9px;
    font-weight: 700;
    line-height: 1;
    flex-shrink: 0;
}

.sb-link:hover .sb-badge{
    background:#000;
    color: #fff;
}

.sb-link.active .sb-badge {
    background: var(--base-color);
    color: #fff;
}
.sb-link .fa-power-off {
    font-size: 12px;
}
.sb-footer {
    margin-top: auto;
    width: 100%;
    border-top: 1px solid var(--sidebar-border);
    background: #fff;
}

.sb-logout {
    width: 100%;
    min-height: 42px;
    padding: 9px 13px;
    display: flex;
    align-items: center;
    gap: 9px;
    background: transparent;
    border: 0;
    color: #555;
    font-size: 12.5px;
    font-weight: 500;
    text-align: left;
    cursor: pointer;
    transition:
        background .13s ease,
        color .13s ease;
}
.sb-logout i {
    width: 15px;
    text-align: center;
    font-size: 13px;
    color: #999;
}
.sb-logout:hover {
    background: #fff2ed;
    color: var(--base-color);
}
.sb-logout:hover i {
    color: var(--base-color);
}





/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 767px) {
    .dash-shell {
        display: block;
    }
    .dash-sidebar {
        width: 100%;
        min-width: 100%;
        height: auto;
        position: static;
        border-right: none;
        border-bottom: 1px solid var(--sidebar-border);
        overflow-x: auto;
        overflow-y: hidden;
    }
    /* Hide user section on mobile */
    .sb-user {
        display: none;
    }
    /* Horizontal navigation */
    .dash-sidebar nav {
        display: flex;
        width: max-content;
    }
    .sb-label {
        display: none;
    }
    .sb-group {
        display: flex;
        width: auto;
        border-bottom: none;
    }
    .sb-link {
        width: auto;
        min-width: max-content;
        min-height: 42px;
        padding: 9px 13px;
        border-left: none;
        border-bottom: 2px solid transparent;
    }
    .sb-link.active {
        border-left: none;
        border-bottom-color: var(--base-color);
    }
    .sb-footer {
        display: none;
    }
}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 480px) {
    .sb-link {
        padding-left: 11px;
        padding-right: 11px;
        font-size: 12px;
    }
    .sb-link-l {
        gap: 7px;
    }
}

</style>

<aside class="dash-sidebar">

    <div class="sb-user">
        <div class="sb-avatar">U</div>
        <div style="min-width:0">
            <div class="sb-name">Customer</div>
            <div class="sb-sub">My Account</div>
        </div>
    </div>

    <nav>
        <div class="sb-label">General</div>

        <div class="sb-group">
            <a href="{{ route('dashboard') }}" class="sb-link active">
                <span class="sb-link-l">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </span>
            </a>

            <a href="{{ route('dashboard') }}" class="sb-link">
                <span class="sb-link-l">
                    <i class="bi bi-person-gear"></i> Profile
                </span>
            </a>
        </div>

        <div class="sb-label">Orders</div>

        <div class="sb-group ">
            <a href="{{ route('customer.all.order', ['status' => 'all']) }}" class="sb-link  {{ request('status') === 'all' ? 'active' : '' }}">
                <span class="sb-link-l">
                    <i class="bi bi-list-ul"></i> All Orders
                </span>
                <span class="sb-badge">{{ $total_order ?? 0 }}</span>
            </a>

            <a href="{{ route('customer.all.order', ['status' => 'pending']) }}" class="sb-link {{ request('status') === 'pending' ? 'active' : '' }}">
                <span class="sb-link-l">
                    <i class="bi bi-clock"></i> Pending
                </span>
                <span class="sb-badge">{{ $p_orders ?? 0 }}</span>
            </a>

           {{-- <a href="{{ route('customer.all.order', ['status' => 'processing']) }}"
                class="sb-link {{request('status') === 'processing' ? 'active' : ''}}">
                <span class="sb-link-l">
                    <i class="bi bi-arrow-repeat"></i> Processing
                </span>
                <span class="sb-badge">{{$counts->processing ?? 0}}</span>
            </a>  --}}


            <a href="{{ route('customer.all.order', ['status' => 'confirmed']) }}" class="sb-link {{request('status') === 'confirmed' ? 'active' : ''}}">
                <span class="sb-link-l">
                    <i class="bi bi-check-circle"></i> Confirmed
                </span>
                <span class="sb-badge">{{ $a_orders ?? 0 }}</span>
            </a>

            <a href="{{ route('customer.all.order', ['status' => 'cancel']) }}" class="sb-link {{request('status') === 'cancel' ? 'active' : ''}}">
                <span class="sb-link-l">
                    <i class="bi bi-x-circle"></i> Cancelled
                </span>
                <span class="sb-badge">{{ $c_orders ?? 0 }}</span>
            </a>
            <a href="{{ route('customer.logout') }}" class="sb-link list-group-item list-group-item-action">
                <span class="sb-link-l">
                    <i class="fa fa-power-off" aria-hidden="true"></i> Logout
                </span>
            </a>
        </div>

    </nav>

    <div class="sb-footer">
        <form action="{{ route('customer.logout') }}" method="POST">
            <button type="submit" class="sb-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

</aside>
{{-- <div class="card cus-dashboard">
    <div class="list-group customer_sidebar">
        <a href="{{ route('customer.dashboard') }}" class="list-group-item active">
            <h5 class="m-0 py-1"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</h5>
        </a>
        <a href="{{ route('customer.profiles') }}" class="list-group-item list-group-item-action">
            <i class="fa fa-user" aria-hidden="true"></i> Profile Update
        </a>
        <a href="{{ route('customer.all.order') }}" class="list-group-item list-group-item-action">
            <i class="fa fa-list" aria-hidden="true"></i> All Orders
        </a>
        <a href="{{ route('customer.canceled.order') }}" class="list-group-item list-group-item-action">
            <i class="fa fa-ban" aria-hidden="true"></i> Canceled Order
        </a>
        <a href="{{ route('customer.change.password') }}" class="list-group-item list-group-item-action">
            <i class="fa fa-lock" aria-hidden="true"></i> Change Password
        </a>

        <a href="{{ route('customer.logout') }}" class="list-group-item list-group-item-action">
            <i class="fa fa-power-off" aria-hidden="true"></i> 
            Logout
        </a>
        
      </div>

</div> --}}
