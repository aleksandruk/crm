@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Інформування клієнта {{$disposition->client}}</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>


        <div>
            <form class="form-horizontal" role="form" method="post" action="{{action('Store\DispositionsController@infoUpdate', 'id='.$disposition->id)}}">
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
                        <textarea class="form-control" id="comment" name="comment" cols="40" rows="1" disabled>{{$disposition->comment}}</textarea>
                        <p class="errorComment text-center alert alert-danger hidden"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="report">Повідомлення для клієнта:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="report" name="report" cols="40" rows="5">Місць: {{$disposition->seats_amount}}, Автобус: {{ $disposition->report['bus_rout'] }}, держ.№: {{ $disposition->report['state_number'] }}, прибуває в {{ $disposition->report['arrival_time'] }} год.</textarea>
                        <p class="errorReport text-center alert alert-danger hidden"></p>
                    </div>
                </div>

                <div class="form-group">
                  <div class="col-md-2"></div>
                  <button type="submit" class="btn btn-primary">Зберегти</button>
                  <a href="{{ route('store.dispositions.shipped_parcels') }}" class="btn btn-danger">Відмінити</a>
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