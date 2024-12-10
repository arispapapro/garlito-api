<?php

    // Models
    use App\Models\Role;

    $counter = Role::all()->count();
?>

<a href="{{url('roles')}}">
    <div  class="garlito-dashboard-card">
        <div class="d-flex align-items-center justify-content-end">
            <div class="d-flex align-items-center">
                <div class="icon">
                    <x-gmdi-recent-actors-r/>
                </div>
                <div class="counter">
                    {{$counter}}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end">
            <label>Roles</label>
        </div>
    </div>
</a>

