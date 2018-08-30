@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Мої пакування</h3>
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
                        <th>Час пакування</th>
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
                                <td>{{ ($disposition->priority == 1) ? 'Високий' : '' }}</td>
                                <td>{{ $disposition->stock_time }}</td>
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

    <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_edit" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="number">Номер:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="number_edit" disabled>
                                <p class="errorNumber text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="client">Клієнт:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client_edit" autofocus>
                                <p class="errorClient text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="comment">Коментар:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="comment_edit" cols="40" rows="5"></textarea>
                                <p class="errorComment text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="seats">Кількість місць:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="seats_amount_edit">
                                <p class="errorSeats text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Зберегти
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Відмінити
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete a form -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Ви впевнені, що хочете видалити наступний запис?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_delete" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="number">Номер:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="number_delete" autofocus>
                                <p class="errorNumber text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="client">Клієнт:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="client_delete" autofocus>
                                <p class="errorClient text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="comment">Коментар:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="comment_delete" cols="40" rows="5"></textarea>
                                <p class="errorComment text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="seats">Кількість місць:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="seats_amount_delete">
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Видалити
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Відмінити
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript') 
    <!-- toastr notifications -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- icheck checkboxes -->
<script type="text/javascript" src="https://jmkleger.com/front/icheck/icheck.min.js"></script>

<script>
    $(window).load(function(){
        $('#dispositionTable').removeAttr('style');
    })
</script>

<script>
    $(document).ready(function(){
        $('.stockPacked').iCheck({
            checkboxClass: 'icheckbox_square-yellow',
            radioClass: 'iradio_square-yellow',
            increaseArea: '20%'
        });
    });
    
</script>

<!-- AJAX CRUD operations -->
    <script type="text/javascript">
    // Edit a post
    // var stockPacked = $('.edit-modal').data('stock_packed');
    // var driverReceived = $('.edit-modal').data('driver_received');
    
    $(document).on('click', '.edit-modal', function() {
        $('.modal-title').text('Змінити');
        $('#id_edit').val($(this).data('id'));
        $('#number_edit').val($(this).data('number'));
        $('#client_edit').val($(this).data('client'));
        $('#comment_edit').val($(this).data('comment'));
        $('#seats_amount_edit').val($(this).data('seats_amount'));
        id = $('#id_edit').val();
        
        // $('#stockPacked_edit').on('ifChecked', function(event){
        //     stockPacked = 1;
        // });
        // $('#stockPacked_edit').on('ifUnchecked', function(event){
        //     stockPacked = 0;
        // });

        // $('#driverReceived_edit').on('ifChecked', function(event){
        //     driverReceived = 1;
        // });
        // $('#driverReceived_edit').on('ifUnchecked', function(event){
        //     driverReceived = 0;
        // });

        $('#editModal').modal('show');
    });

    function timestamp () {
      now = new Date();
      year = "" + now.getFullYear();
      month = "" + (now.getMonth() + 1);
      if (month.length == 1) { month = "0" + month; }
      day = "" + now.getDate();
      if (day.length == 1) { day = "0" + day; }
      hour = "" + now.getHours();
      if (hour.length == 1) { hour = "0" + hour; }
      minute = "" + now.getMinutes();
      if (minute.length == 1) { minute = "0" + minute; }
      second = "" + now.getSeconds();
      if (second.length == 1) { second = "0" + second; }
      return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    }

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'PUT',
            url: 'dispositions/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#id_edit").val(),
                'nr_rach': $('#number_edit').val(),
                'client': $('#client_edit').val(),
                'comment': $('#comment_edit').val(),
                'seats_amount' : $('#seats_amount_edit').val(),
                'stock_time' : timestamp(),
                'stock_id' : $('.edit-modal').data('user-id'),
                'status' : 1
            },
            success: function(data) {
                var status;
                if (data.status = 1) {
                    status = 'Готово до відправки';
                }
                $('.errorTitle').addClass('hidden');
                $('.errorContent').addClass('hidden');
                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                    }, 500);
                    if (data.errors.title) {
                        $('.errorTitle').removeClass('hidden');
                        $('.errorTitle').text(data.errors.title);
                    }
                    if (data.errors.content) {
                        $('.errorContent').removeClass('hidden');
                        $('.errorContent').text(data.errors.content);
                    }
                } else {
                    toastr.success('Запис успішно оновлено!', 'Success Alert', {timeOut: 5000});
                    $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td class='col1'>" + data.id + "</td><td>"+data.nr_rach+"</td><td>"+data.client+"</td><td>"+data.comment+"</td><td>"+data.seats_amount+"</td><td>"+status+"</td><td><button class='edit-modal btn btn-info' data-id='"+data.id+"' data-number='"+data.nr_rach+"' data-client='"+data.client+"' data-comment='"+data.comment+"' data-priority='"+data.priority+"' data-seats_amount='"+data.seats_amount+"' data-status='"+data.status+"'><span class='glyphicon glyphicon-edit'></span> Змінити</button> <button class='delete-modal btn btn-danger' data-id='"+data.id+"' data-number='"+data.nr_rach+"' data-client='"+data.client+"' data-comment='"+data.comment+"' data-priority='"+data.priority+"' data-seats_amount='"+data.seats_amount+"' data-status='"+data.status+"'><span class='glyphicon glyphicon-trash'></span> Видалити</button></td></tr>");
                    // if (data.stock_packed == 1) {
                    //     $('.item' + data.id).find('td.stock').append('<span class="glyphicon glyphicon-ok-sign" style="color: green; font-size: 24px"></span>');
                    // }

                    // else {
                    //     $('.item' + data.id).find('td.stock').append('<span class="glyphicon glyphicon-minus-sign" style="color: red; font-size: 24px"></span>');
                    // }
                    // if (data.driver_received == 1) {
                    //     $('.item' + data.id).find('td.driver').append('<span class="glyphicon glyphicon-ok-sign" style="color: green; font-size: 24px"></span>');
                    // }

                    // else {
                    //     $('.item' + data.id).find('td.driver').append('<span class="glyphicon glyphicon-minus-sign" style="color: red; font-size: 24px"></span>');
                    // }

                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            }
        });
    });
    
    // delete a post
    $(document).on('click', '.delete-modal', function() {
        $('.modal-title').text('Видалити');
        $('#id_delete').val($(this).data('id'));
        $('#number_delete').val($(this).data('number'));
        $('#client_delete').val($(this).data('client'));
        $('#seats_amount_delete').val($(this).data('seats_amount'));
        $('#deleteModal').modal('show');
        id = $('#id_delete').val();
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'DELETE',
            url: 'dispositions/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
            },
            success: function(data) {
                toastr.success('Запис успішно видалено!', 'Сповіщення про успіх', {timeOut: 5000});
                $('.item' + data['id']).remove();
                $('.col1').each(function (index) {
                    $(this).html(index+1);
                });
            }
        });
    });
</script>

@endsection