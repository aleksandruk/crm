@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Звіт по диспозиції {{$disposition->nr_rach}}</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>


        <div>
            <form class="form-horizontal" role="form" method="post" action="{{action('Store\DispositionsController@driverReportUpdate', 'id='.$disposition->id)}}">
                <div class="form-group">
                    {{csrf_field()}}
                    <input name="_method" type="hidden" value="PATCH">
                    <label class="control-label col-sm-2" for="id">ID:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id" name="id" value="{{$disposition->id}}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="seats">Номер:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nr_rach" name="nr_rach" value="{{$disposition->nr_rach}}" disabled>
                        <p class="errorSeats text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="client">Клієнт:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="client" name="client" value="{{$disposition->client}}" disabled>
                        <p class="errorClient text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="seats">Кількість місць:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="seats_amount" name="seats_amount" value="{{$disposition->seats_amount}}" disabled>
                        <p class="errorSeats text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="comment">Коментар:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="comment" name="comment" cols="40" rows="1" disabled>{{ $disposition->comment }}</textarea>
                        <p class="errorComment text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="rout">Маршрут автобуса:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bus_rout" name="bus_rout" value="@if ($disposition->report) {{ $disposition->report['bus_rout'] }} @endif">
                        <p class="errorSeats text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="number">Державний номер:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="state_number" name="state_number" value="@if ($disposition->report) {{ $disposition->report['state_number'] }} @endif">
                        <p class="errorSeats text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="arrival">Час прибуття в місце призначення:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="arrival_time" name="arrival_time" value="@if ($disposition->report) {{ $disposition->report['arrival_time'] }} @endif">
                        <p class="errorSeats text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="note">Примітка:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="note" name="note" cols="40" rows="2">@if ($disposition->report) {{ $disposition->report['note'] }} @endif</textarea>
                        <p class="errorReport text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-md-2"></div>
                  <button type="submit" class="btn btn-primary">Зберегти</button>
                  <a href="{{ url('store/dispositions/my_parcels') }}" class="btn btn-danger">Відмінити</a>
                </div>
            </form>
        </div>
    </div>
  
@stop

@section('javascript') 

@if(session()->has('message'))
    <script type="text/javascript">
        toastr.success('{{ session()->get('message') }}', 'Сповіщення про успіх', {timeOut: 5000});
    </script>
@endif

@if(session()->has('errors'))
    <script type="text/javascript">
        toastr.error('Не коректно заповнені поля', 'Сповіщення про помилку', {timeOut: 5000});
    </script>
@endif

@endsection 