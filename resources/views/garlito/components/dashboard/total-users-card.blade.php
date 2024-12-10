<?php

    // Models
    use App\Models\User;

    $counter = User::all()->count();
?>

<a href="{{url('users')}}">
    <div  class="garlito-dashboard-card">
        <div class="d-flex align-items-center justify-content-end">
            <div class="d-flex align-items-center">
                <div class="icon">
                    <x-gmdi-group-r/>
                </div>
                <div class="counter">
                    {{$counter}}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end">
            <label>Users</label>
        </div>
    </div>
</a>

