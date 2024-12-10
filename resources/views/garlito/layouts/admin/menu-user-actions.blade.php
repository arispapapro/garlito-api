<div class="btn-group">

    <div id="menuUserActionsButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <x-gmdi-person-r/>
    </div>
    <ul class="dropdown-menu">
        <form method="POST" action="{{url('logout')}}">
            @csrf
            <input type="submit" class="dropdown-item" value="Logout">
        </form>
    </ul>
</div>
