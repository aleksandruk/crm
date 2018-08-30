@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Готовий до відправки товар</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped dt-select" id="dispositionTable">
                <thead>
                    <tr>
                        <th valign="middle">№</th>
                        <th>Диспозиція</th>
                        <th>Клієнт</th>
                        <th>Коментар</th>
                        <th>Місць</th>
                        <th>Статус</th>
                        <th>Пріоритет</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($dispositions) > 0)
                        @foreach ($dispositions as $indexKey => $disposition)
                                <tr class="item{{$disposition->id}} {{ ($disposition->priority == 1) ? 'success' : 'simple' }}" data-stock-time="{{$disposition->stock_time}}">
                                    <td class="col1">{{ $indexKey+1 }}</td>
                                    <td>{{ $disposition->nr_rach }}</td>
                                    <td>{{ $disposition->client }}</td>
                                    <td>{{ $disposition->comment }}</td>
                                    <td>{{ $disposition->seats_amount }}</td>
                                    <td>@if ($disposition->status == 1) Готово до відправки @endif</td>
                                    <td>@if ($disposition->priority == 1) Високий @endif</td>
                                </tr>
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

<!-- receive notifications -->
    <script src="{{ asset('js/echo.js') }}"></script>
        <script>

            window.Echo = new Echo({
                broadcaster: 'socket.io',
                host: window.location.hostname + ':6001'
            });

            Echo.channel('dispositions')
            .listen('NewCommentNotification', (e) => {
                //alert(e.disposition.client);
                var status;
                if (e.disposition.status = 1) {
                    status = 'Готово до відправки';
                }
                if (e.disposition.driver_id) {
                    $('#dispositionTable tr.item'+e.disposition.id).remove();
                    toastr.success('Диспозиція № '+e.disposition.nr_rach+' прийнята водієм', 'Увага!', {timeOut: 5000});
                }
                var priority;
                if (e.disposition.priority == 1 && !e.disposition.driver_id) {
                    $('#dispositionTable tr.item'+e.disposition.id).remove();
                    priority = 'Високий';
                    $('#dispositionTable').prepend('<tr class="item'+e.disposition.id+' success" data-stock-time="'+e.disposition.stock_time+'"><td class="col1">1</td><td>'+e.disposition.nr_rach+'</td><td>'+e.disposition.client+'</td><td>'+e.disposition.comment+'</td><td>'+e.disposition.seats_amount+'</td><td>'+status+'</td><td>'+priority+'</td>');

                    $('#dispositionTable tr').each(function (i) {
                       $("td:first", this).html(i);
                    });
                    toastr.warning('У диспозиції № '+e.disposition.nr_rach+' високий пріоритет!', 'Увага!', {timeOut: 5000});
                }
                else if (e.disposition.priority !== 1 && !e.disposition.driver_id) {
                    $('#dispositionTable tr.item'+e.disposition.id).remove();
                    if ($('#dispositionTable tr.success').length) {
                        $('#dispositionTable tr.success').last().after('<tr class="item'+e.disposition.id+' simple" data-stock-time="'+e.disposition.stock_time+'"><td class="col1">1</td><td>'+e.disposition.nr_rach+'</td><td>'+e.disposition.client+'</td><td>'+e.disposition.comment+'</td><td>'+e.disposition.seats_amount+'</td><td>'+status+'</td><td>'+e.disposition.priority+'</td>');
                        
                        $('#dispositionTable tr').each(function (i) {
                           $("td:first", this).html(i);
                        });
                        toastr.success('Диспозиція № '+e.disposition.nr_rach+' готова до відправки!', 'Увага!', {timeOut: 5000});
                    }
                    else {
                        $('#dispositionTable').prepend('<tr class="item'+e.disposition.id+' simple" data-stock-time="'+e.disposition.stock_time+'"><td class="col1">1</td><td>'+e.disposition.nr_rach+'</td><td>'+e.disposition.client+'</td><td>'+e.disposition.comment+'</td><td>'+e.disposition.seats_amount+'</td><td>'+status+'</td><td>'+e.disposition.priority+'</td>');

                        $('#dispositionTable tr').each(function (i) {
                           $("td:first", this).html(i);
                        });
                        toastr.success('Диспозиція № '+e.disposition.nr_rach+' готова до відправки!', 'Увага!', {timeOut: 5000});
                    }
                }
            });
        </script>
    <!-- receive notifications -->
@endsection