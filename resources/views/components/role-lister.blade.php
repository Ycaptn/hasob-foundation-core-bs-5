
@if (isset($role_user) && $role_user != null)
    @php
        $userRoles = $role_user->getRoleNames();
    @endphp
    @foreach ($userRoles as $idx=>$roleName)
        <span class="my-1 badge bg-primary fw-normal mx-2">{{ $roleName }}</span>
    @endforeach
@endif