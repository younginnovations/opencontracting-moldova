@extends('admin.user.layout')

@section('content')
    {{--confirmation modal--}}
    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">You are about to change the status of the user.</h4>
                </div>

                <div class="modal-body">
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                    <a class="btn btn-info btn-ok">YES</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if($errors->has('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> {{$errors->first('success')}}
                    </div>
                    @elseif($errors->has('error'))
                    <div class="alert alert-success">
                        <strong>Error!</strong> {{$errors->first('error')}}
                    </div>
                @endif
                <h2>User Manager</h2>
                <hr>
                <a href="{{ route('userManager.add') }}" class="btn btn-default pull-right">
                    <i class="fa fa-plus" aria-hidden="true"></i> New User
                </a>
                <h4>List of registered users</h4>
                <br>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Created</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{$user->username }}</td>
                            <td>{{ (!empty($user->created_at)) ? $user->created_at->diffForHumans() : '' }}</td>
                            <td>
                                <a href="{{ route('userManager.edit', $user->_id) }}">Edit</a> |
                                <a href="#"
                                   data-href="{{ route('userManager.status', $user->_id, ($user->status) ? 'deactivate' : 'activate') }}"
                                   data-toggle="modal" data-target="#confirm-modal">
                                    {{ ($user->status) ? 'Deactivate' : 'Activate' }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#confirm-modal').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
@endsection