<?php

    // Models
    use App\Models\User;

    $counter = 0;
?>

<a href="{{url('notifications')}}">
    <div  class="garlito-dashboard-card">
        <div class="d-flex align-items-center justify-content-end">
            <div class="d-flex align-items-center">
                <div class="icon">
                    <x-gmdi-notifications-r/>
                </div>
                <div class="counter">
                    {{$counter}}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end">
            <label>Notifications</label>
        </div>
    </div>
</a>

