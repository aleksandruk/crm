@extends('layouts.auth')
<style type="text/css">
    .nmpd-grid {border: none; padding: 20px; width: 249px;}
    .nmpd-grid>tbody>tr>td {border: none;}
    input.nmpd-target[readonly] {background-color: white; cursor: pointer;}
    
    /* Some custom styling for Bootstrap */
    .qtyInput {display: block;
        width: 100%;
        padding: 6px 12px;
        color: #555;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: right;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Логування для працівників складу</div>
                <div class="panel-body">
                    
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were problems with input:
                            <br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (count($users) > 0)
                        @foreach ($users as $user)
                        <button class="btn btn-default btn-lg user" style="border-radius: 12px;" data-id="{{ $user->id }}">{{ $user->name }}</button>
                        @endforeach
                    @else
                            <p>@lang('global.app_no_entries_in_table')</p>
                    @endif
                    <form id ="login" class="form-horizontal" role="form" method="POST" action="{{ route('store.login.submit') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" class="form-control" name="pin" id="pin">
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript') 
<script type="text/javascript">
    $(function() {
        $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
        $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
        $.fn.numpad.defaults.displayTpl = '<input class="form-control" type="password" />';
        $.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default btn-lg"></button>';
        $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn btn-lg" style="width: 100%;"></button>';
        $.fn.numpad.defaults.hidePlusMinusButton = true;
        $.fn.numpad.defaults.hideDecimalButton = true;
        $.fn.numpad.defaults.textDone = 'Увійти';
        $.fn.numpad.defaults.textDelete = 'Видалити';
        $.fn.numpad.defaults.textClear = 'Очистити';
        $.fn.numpad.defaults.textCancel = 'Відмінити';
        $.fn.numpad.defaults.onKeypadCreate = function(){
            $(this).find('.done').addClass('btn-primary');
        };
        $.fn.numpad.defaults.onKeypadClose = function(){
            
            if ($(this).find('.nmpd-display').val()) {
                $('#login').submit();
            }
            
        };
        $(document).ready(function(){
            $('.user').numpad({
                target: $('#pin')
            });
        });
    });
</script>

@endsection