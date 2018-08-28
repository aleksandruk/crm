@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Панель управління</div>

                <div class="panel-body">
                    Ви увійшли в систему, як {{ Auth::User()->name }}!
                </div>
            </div>
        </div>
    </div>
@endsection
