@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Відправлений товар</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped dt-select" id="dispositionTable">
                <thead>
                    <tr>
                        <th valign="middle">№</th>
                        <th valign="middle">&nbsp;</th>
                        <th>Диспозиція</th>
                        <th>Клієнт</th>
                        <th>Коментар</th>
                        <th>Місць</th>
                        <th>Пріоритет</th>
                        <th>Хто пакував</th>
                        <th>Час пакування</th>
                        <th>Водій</th>
                        <th>Час відправки</th>
                        <th>&nbsp;</th>
                    </tr>
                    {{ csrf_field() }}
                </thead>
                
                <tbody>
                    @if (count($dispositions) > 0)
                        @foreach ($dispositions as $indexKey => $disposition)
                                @if ($disposition->status == 3)
                                <tr class="item{{$disposition->id}} {{ ($disposition->priority == 1) ? 'success' : 'info' }} accordion-toggle">
                                @else
                                <tr class="item{{$disposition->id}} info">
                                @endif
                                    <td class="col1">{{ $indexKey+1 }}</td>
                                    <td>
                                        @if ($disposition->status == 3)<span class="fa fa-caret-down" data-toggle="collapse" data-target="#info{{$disposition->id}}" style="cursor: pointer"></span>@endif
                                    </td>
                                    <td>{{ $disposition->nr_rach }}</td>
                                    <td>{{ $disposition->client }}</td>
                                    <td>{{ $disposition->comment }}</td>
                                    <td>{{ $disposition->seats_amount }}</td>
                                    <td>{{ ($disposition->priority == 1) ? 'Високий' : 'Звичайний' }}</td>
                                    <td>{{ $disposition->storekeeper->name }}</td>
                                    <td>{{ $disposition->stock_time }}</td>
                                    <td>{{ $disposition->driver->name }}</td>
                                    <td>{{ $disposition->driver_time }}</td>
                                    <td>
                                        <a href="{{action('Store\DispositionsController@info', $disposition->id)}}" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span> Опрацювати</a>
                                    </td>
                                </tr>
                                @if ($disposition->status == 3)
                                <tr >
                                    <td colspan="12" class="hiddenRow warning" style="padding: 0;"><div class="accordian-body collapse" id="info{{$disposition->id}}"> Деталі:<br>Автобус <strong>{{ $disposition->report['bus_rout'] }}</strong>, держ. № <strong>{{ $disposition->report['state_number'] }}</strong>, прибуває в <strong>{{ $disposition->report['arrival_time'] }}</strong></div> </td>
                                </tr>
                                @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    

    
@stop

@section('javascript') 

<script>
    $(window).load(function(){
        $('#dispositionTable').removeAttr('style');
    })
</script>

@if(session()->has('message'))
    <script type="text/javascript">
        toastr.success('{{ session()->get('message') }}', 'Сповіщення про успіх', {timeOut: 5000});
    </script>
@endif

@if(session()->has('errors'))
    <script type="text/javascript">
        toastr.error('{{ session()->get('errors') }}', 'Сповіщення про помилку', {timeOut: 5000});
    </script>
@endif

@endsection