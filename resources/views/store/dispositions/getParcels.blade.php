@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Отримати товар</h3>
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
                        <th>Пріоритет</th>
                        <th>&nbsp;</th>
                    </tr>
                    {{ csrf_field() }}
                </thead>
                
                <tbody>
                    @if (count($dispositions) > 0)
                        @foreach ($dispositions as $indexKey => $disposition)
                                <tr class="item{{$disposition->id}} {{ ($disposition->priority == 1) ? 'success' : '' }}" data-stock-time="{{$disposition->stock_time}}">
                                    <td class="col1">{{ $indexKey+1 }}</td>
                                    <td>{{ $disposition->nr_rach }}</td>
                                    <td>{{ $disposition->client }}</td>
                                    <td>{{ $disposition->comment }}</td>
                                    <td>{{ $disposition->seats_amount }}</td>
                                    <td>@if ($disposition->priority == 1) Високий @endif</td>
                                    <td>
                                        {!! Form::open(['method' => 'PATCH', 'action' => ['Store\DispositionsController@driverUpdate','id='.$disposition->id]]) !!}
                                        {!! Form::submit('Прийняти', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
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