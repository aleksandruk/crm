@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Неопрацьовані диспозиції</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped dt-select" id="dispositionTable">
                <thead>
                    <tr>
                        <th valign="middle">№</th>
                        <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                        <th>Диспозиція</th>
                        <th>Клієнт</th>
                        <th>Коментар</th>
                        <th>Місць</th>
                        <th>Статус</th>
                        <th>Пріоритет</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($dispositions) > 0)
                        @foreach ($dispositions as $indexKey => $disposition)
                            <tr class="item{{$disposition->id}} {{ ($disposition->priority == 1) ? 'success' : '' }}">
                                <td class="col1">{{ $indexKey+1 }}</td>
                                <td>{{ $disposition->nr_rach }}</td>
                                <td>{{ $disposition->client }}</td>
                                <td>{{ $disposition->comment }}</td>
                                <td>{{ $disposition->seats_amount }}</td>
                                <td>@if ($disposition->status == 0) Готово до пакування @endif</td>
                                <td>@if ($disposition->priority == 1) Високий @endif</td>
                                <td>
                                    <a href="{{action('Store\DispositionsController@edit', $disposition->id)}}" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span> Змінити</a>

                                    <a href="{{action('Store\DispositionsController@destroy', $disposition->id)}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Видалити</a>
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

@endsection