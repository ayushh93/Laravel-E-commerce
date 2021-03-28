<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('adminDashboard') }}"><i class="la la-home"></i> <span>Back to Home</span></a>
                </li>
                <li class="menu-title">Settings</li>
                @if(Session::get('admin_page') == 'theme')
                    @php $active = "active" @endphp
                @else
                    @php $active = "" @endphp
                @endif
                <li class="{{ $active }}">
                    <a href="{{ route('theme') }}"><i class="la la-photo"></i> <span>Theme Settings</span></a>
                </li>
                @if(Session::get('admin_page') == 'password')
                    @php $active = "active" @endphp
                @else
                    @php $active = "" @endphp
                @endif
                <li class="{{ $active }}">
                    <a href="{{ route('changePassword') }}"><i class="la la-lock"></i> <span>Change Password</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

