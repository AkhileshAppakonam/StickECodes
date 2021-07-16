@extends('layouts.app')

@section('content')
    <section id="editSecurityProfile">
        <form id="editSecurityProfileForm" name="editSecurityProfileForm" enctype="multipart/form-data" action="" method="POST">
            @csrf

            <div class="container">
                <header class="mb-4"><h1>Edit Security Profile</h1></header>

                <div class="row m-2">
                    <div class="form-group col-12">
                        <label for="securityProfileTitle" class="col-form-label">Profile Name</label>
                        <input id="securityProfileTitle" type="text" class="form-control" placeholder="Insert Profile Name Here" required>
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
                            <tr class="mb-2 pb-3 border-bottom">
                                <td><p></p></td>
                                <td><input type="text" class="form-control" placeholder="Insert Email Address Here"></td>
                                <td><input type="text" class="form-control" placeholder="Insert Name Here"></td>
                                <td>
                                    <select id="choosePermissions" name="securityProfilePermissions" class="form-control">
                                        <option value="view">View Only</option>
                                        <option value="update">View and Update</option>
                                        <option value="full">Full Control</option>
                                    </select>
                                </td>
                                <td><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td>
                            </tr>
                        </table>
                    </div>
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
            e.parentElement.parentElement.remove();
        }

        function addUser() {
            var start = $('#editSecurityProfileTable'),
                newRow = $('<tr class="mb-2 pb-3 border-bottom"><td><p></p></td>' +
                        '<td><input type="text" class="form-control" placeholder="Insert Email Address Here"></td>' +
                        '<td><input type="text" class="form-control" placeholder="Insert Name Here"></td>' +
                        '<td><select id="choosePermissions" name="securityProfilePermissions" class="form-control"><option value="view">View Only</option><option value="update">View and Update</option><option value="full">Full Control</option></select></td>' +
                        '<td><input type="button" value="Remove" class="remove btn btn-outline-dark" onclick="remove(this)"></td></tr>');
            $(start).append(newRow);
        }
    </script>
@endsection