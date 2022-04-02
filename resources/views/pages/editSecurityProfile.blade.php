@extends('layouts.app')

@section('content')
    <section id="editSecurityProfile">
        <form id="editSecurityProfileForm" name="editSecurityProfileForm" enctype="multipart/form-data" action="/public/index.php/securityProfilePage/{{$securityProfile -> id}}/editSecurityProfile/{{$page -> id ?? ''}}" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>{{$headerType ?? "Edit Security Profile"}}</h1></header>

                @include('inc.messages')

                <div class="row m-2">
                    <div class="form-group col-12 headerDetails">
                        <div class="form-group col-6 px-0">
                            <label for="securityProfileTitle" class="col-form-label">Profile Name</label>
                            <input id="securityProfileTitle" type="text" name="securityProfileName" class="form-control" placeholder="Insert Profile Name Here" value="{{$securityProfile -> profile_name}}" required>
                        </div>
                        <div class="form-group col-6 pl-4" >
                            <div class="container p-0">
                                <label for="public" class="col-form-label mb-2 px-1">Public</label>
                            </div>
                            <input type="checkbox" name="profileType" value="gpub" class="ml-3" 
                                @if (($securityProfile -> profile_type) === "gpub")
                                    {{"checked"}}
                                @endif
                            >
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="container px-0 border-bottom">
                            <h2 class="py-3">Profile Users</h2>
                            <div class="pr-1">
                                <input type="button" value="Add Row" class="btn btn-dark addRow" onclick="addUser()">
                            </div>
                        </div>

                        <table id="editSecurityProfileTable">
                            <tr class="mb-3 pb-2 pt-1 border-bottom">
                                <th>Row</th>
                                <th>Email Address</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th>Remove Row</th>
                            </tr>
                            
                            @if (count($securityProfile -> security_profile_users) > 0)

                                <input type="hidden" id="DBspUsersCount" name="DBspUsersCount" class="form-control" value="{{count($securityProfile -> security_profile_users)}}">
                                <input type="hidden" id="DBspUsersCountRemaining" name="DBspUsersCountRemaining" class="form-control" value="{{count($securityProfile -> security_profile_users)}}">

                                {{-- Key is really a counter variable --}}
                                @foreach ($securityProfile -> security_profile_users as $key => $securityProfileUser)
                                    <tr class="mb-2 pb-3 border-bottom">
                                        <td><p></p></td>
                                        <td><input type="text" name="addUserEmailUpdate{{$key}}" class="form-control" placeholder="Insert Email Address Here" value="{{$securityProfileUser->user->email}}"></td>
                                        <td><input type="text" name="addUserNameUpdate{{$key}}" class="form-control" placeholder="Insert Name Here" value="{{$securityProfileUser->user->name}}"></td>
                                        <td>
                                            <select id="choosePermissions" name="addUserPermissionsUpdate{{$key}}" class="form-control">
                                                <option value="view" @if ($securityProfileUser->permissions == 1) {{"selected"}} @endif>View Only</option>
                                                <option value="update" @if ($securityProfileUser->permissions == 2) {{"selected"}} @endif>View and Update</option>
                                                <option value="full" @if ($securityProfileUser->permissions == 3) {{"selected"}} @endif>Full Control</option>
                                            </select>
                                        </td>
                                        <td><input type="button" value="Remove" class="remove btn btn-outline-dark hasSPUser" onclick="remove(this)"></td>
                                    </tr>
                                    {{-- This input has to be outside tr because remove btn removes tr and therefore any input within it --}}
                                    <input type="hidden" class="form-control" name="securityProfileUserId{{$key}}" value="{{$securityProfileUser->id}}">
                                @endforeach
                            @endif
                                

                            <tr class="mb-2 pb-3 border-bottom">
                                <td><p></p></td>
                                <td><input type="text" name="addUserEmail0" class="form-control" placeholder="Insert Email Address Here"></td>
                                <td><input type="text" name="addUserName0" class="form-control" placeholder="Insert Name Here"></td>
                                <td>
                                    <select id="choosePermissions" name="addUserPermissions0" class="form-control">
                                        <option value="view">View Only</option>
                                        <option value="update">View and Update</option>
                                        <option value="full">Full Control</option>
                                    </select>
                                </td>
                                <td><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                            </tr>
                        </table>
                    </div>

                    <input type="hidden" id="userCount" name="userCount" class="form-control">

                    <div class="form-group col-12">
                        <div class="submitContainer">
                            <input type="submit" class="form-control btn btn-primary" value="Save Changes">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script type="text/javascript">
        function remove(e) {
            if (e.classList.contains('hasSPUser')) {
                var DBspUsersCountRemaining = document.getElementById('DBspUsersCountRemaining');
                DBspUsersCountRemaining.value = DBspUsersCountRemaining.value-1;
            }
            e.parentElement.parentElement.remove();
            userCount();
        }
        var x = 1;
        function addUser() {
            var start = $('#editSecurityProfileTable'),
                newRow = $('<tr class="mb-2 pb-3 border-bottom"><td><p></p></td>' +
                        '<td><input type="text" name="addUserEmail'+x+'" class="form-control" placeholder="Insert Email Address Here"></td>' +
                        '<td><input type="text" name="addUserName'+x+'" class="form-control" placeholder="Insert Name Here"></td>' +
                        '<td><select id="choosePermissions" name="addUserPermissions'+x+'" class="form-control"><option value="view">View Only</option><option value="update">View and Update</option><option value="full">Full Control</option></select></td>' +
                        '<td><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);
            userCount();
            x++;
        }
    </script>

    <script type="text/javascript">
        function userCount() {
            var userCount = document.getElementById('userCount');
            var usersTableRowCount = document.getElementById('editSecurityProfileTable').rows.length;
            userCount.value = usersTableRowCount-2;
        }
    </script>

    <script type="text/javascript">
        window.onload = function() {
            userCount();
        }
    </script>
@endsection