<aside id="garlitoSidebar">

    <!-- Sidebar Toggle Button -->
    <div id="garlitoSidebarButtonHolder" class="d-flex align-items-center justify-content-end">
        <div id="garlitoSidebarButtonClose"><x-gmdi-toggle-on-o/></div>
        <div id="garlitoSidebarButtonOpen"><x-gmdi-toggle-off-o/></div>
    </div>

    <ul id="garlitoSidebarItems">

        <li class="sidebar-category">{{__('sidebar.dashboard')}}</li>
        <a href="{{url('dashboard')}}"><li><x-gmdi-dashboard-r/><span class="sidebar-item-label">{{__('sidebar.dashboard')}}</span></li></a>

        <li class="sidebar-category">{{__('sidebar.oauth_2_auth')}}</li>
        <a href="{{url('clients')}}"><li><x-gmdi-private-connectivity-r/><span class="sidebar-item-label">{{__('sidebar.clients')}}</span></li></a>
        <a href="{{url('access-tokens')}}"><li><x-gmdi-lock-open-r/><span class="sidebar-item-label">{{__('sidebar.access_tokens')}}</span></li></a>

        <a href="{{url('users')}}"><li><x-gmdi-group-r/><span class="sidebar-item-label">{{__('sidebar.users')}}</span></li></a>
        <a href="{{url('roles')}}"><li><x-gmdi-recent-actors-r/><span class="sidebar-item-label">{{__('sidebar.roles')}}</span></li></a>

        <li class="sidebar-category">{{__('sidebar.system_settings')}}</li>
        <a href="{{url('settings')}}"><li><x-gmdi-settings-r/><span class="sidebar-item-label">{{__('sidebar.settings')}}</span></li></a>
    </ul>

</aside>
