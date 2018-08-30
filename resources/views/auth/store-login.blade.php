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

                    <form id ="login" class="form-horizontal"
                          role="form"
                          method="POST"
                          action="{{ route('store.login.submit') }}">
                        <input type="hidden"
                               name="_token"
                               value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">PIN</label>

                            <div class="col-md-6">
                                <input type="password"
                                       class="form-control"
                                       name="pin"
                                       value="{{ old('pin') }}">
                            </div>
                        </div>

                        

                        


                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit"
                                        class="btn btn-primary"
                                        style="margin-right: 15px;">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript') 
<script type="text/javascript">
    $('input[name="pin"]').numpad();
$('.done').click(function() {
    //$('#login').submit();
    alert('done');
});
</script>
@endsection