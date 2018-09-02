@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Створення нової накладної</h3>
    <div id="status-result">
        <div class="row">
            <div id="status-result-loader" class="col-md-2 col-md-offset-3" style="position: absolute; top: 10%; z-index: 9999;"></div>
        </div>
            <div id="status-result-ok" class="alert alert-success fade in alert-dismissible" style="display: none; margin-top:20px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <strong>Накладна успішно створена!</strong><br>
                Номер ЕН: <span class="save_ttn_number"></span><br>
                Вартість доставки: <span class="save_ttn_cost"></span> грн.<br>
                <a href="javascript:void(0)" id="print_en" class="btn btn-info" role="button" style="text-align: center;">Надрукувати ЕН</a>
            </div>
        <div id="status-result-error" class="alert alert-danger fade in alert-dismissible" style="display: none; margin-top:20px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Помилка!</strong><br><span class="save_ttn_error"></span><br></div>
        </div>
    <form>
        <div class="form-group col-xs-6">
            <div class="col-xs-12">
                <button id="change_receiver" type="button" class="btn btn-info col-xs-12" data-toggle="modal" data-target="#changeReceiverModal">Натисніть для зміни ОДЕРЖУВАЧА</button>
            </div>
            <div class="col-xs-12">
                <dl id="recipientInfoTable" class="dl-horizontal">
                    <dt>Місто:</dt>
                    <dd>
                        <span id="RecipientCityText" data-original-title="" title=""></span>
                        <input type="hidden" name="CityRecipient" id="RecipientCityRef" value="">
                    </dd>

                    <dt>Одержувач:</dt>
                    <dd>
                        <span id="RecipientCounterpartyText" data-original-title="" title=""></span>
                        <input type="hidden" name="Recipient" id="RecipientCounterpartyRef" value="">
                    </dd>

                    <dt>Адреса:</dt>
                    <dd>
                        <span id="RecipientAddressText" data-original-title="" title=""></span>
                        <input type="hidden" name="RecipientAddress" id="RecipientAddressRef" value="">
                    </dd>

                    <dt>Контактна особа:</dt>
                    <dd>
                        <span id="RecipientContactText" data-original-title="" title=""></span>
                        <input type="hidden" name="ContactRecipient" id="RecipientContactRef" value="">
                    </dd>

                    <dt>Телефон:</dt>
                    <dd>
                        <span id="RecipientPhoneText" data-original-title="" title=""></span>
                        <input type="hidden" name="RecipientsPhone" id="RecipientPhone" value="">
                    </dd>
                </dl>
            </div>
            <div class="col-xs-12">
                <label for="payer">Платник:</label>
                    <ul id="payer" class="nav nav-pills nav-stacked">
                        <li><a href="javascript:void(0)" class="list-group-item active" data-type="Recipient">Одержувач</a></li>
                        <li><a href="javascript:void(0)" class="list-group-item" data-type="Sender">Відправник</a></li>
                    </ul>
                    <br><br>
            </div>
            <div class="col-xs-12">
                <label for="payment_type">Форма оплати:</label>
                    <ul id="payment_type" class="nav nav-pills nav-stacked">
                        <li><a href="javascript:void(0)" class="list-group-item active" data-type="Cash">Готівка</a></li>
                        <li><a href="javascript:void(0)" class="list-group-item" data-type="NonCash">Безготівковий</a></li>
                    </ul>
            </div>
        </div>
        <div class="form-group col-xs-6">
            <div class="col-xs-12">
                <label for="date">Дата відправки:</label>
                <input type="text" name="DateTime" id="DateTime" value="">
                <br><br>
            </div>
            
            <table class="table">
                <tr>
                    <td>Загальна вага</td>
                    <td><input type="text" name="Weight" id="Weight" value="" placeholder="введіть вагу"></td>
                </tr>
                <tr>
                    <td>Загальний об'єм відправлення</td>
                    <td><input type="text" name="VolumeGeneral" id="VolumeGeneral" value="" disabled></td>
                </tr>
                <tr>
                    <td>Кількість місць</td>
                    <td><input type="text" name="SeatsAmount" id="SeatsAmount" value="" placeholder="введіть к-сть місць"></td>
                </tr>
                <tr>
                    <td>Оголошена вартість, грн</td>
                    <td><input type="text" name="Cost" id="Cost" value="" placeholder="введіть вартість"></td>
                </tr>
                <tr>
                    <td>Опис відправлення</td>
                    <td><input type="text" name="Description" id="Description" value="Автозапчастини"></td>
                </tr>
            </table>
            <div class="col-xs-12">
                <label for="return_shipping">Зворотня доставка:</label>
                <select id="return_shipping" class="form-control">
                    <option value="0">Немає зворотньої доставки</option>
                    <option value="Money">Грошовий переказ</option>
                </select>
                <div id="backdeliv" style="display: none; padding: 10px 0px;"><input type="text" name="BackwardDeliveryMoney" id="BackwardDelivery" value="" placeholder="введіть суму зворотньої доставки" style="width: 225px; height: 40px;"><br><br>
                    <label for="redeliveryPayerType">Платник зворотньої доставки:</label>
                    <ul id="redeliveryPayerType" class="nav nav-pills nav-stacked">
                        <li><a href="javascript:void(0)" class="list-group-item" data-type="Sender">Відправник</a></li>
                        <li><a href="javascript:void(0)" class="list-group-item active" data-type="Recipient">Одержувач</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="clearfix"></div>
        <div style="position: relative; text-align: center;">
            <input id="submit_main_form" type="submit" class="btn btn-success col-md-2" value="Зберегти">
            <button id="cancel_main_form" type="button" class="btn btn-warning col-md-2">Відмінити</button>
        </div>
    </form>
    <!-- Modal -->
  <div class="modal fade" id="changeReceiverModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ОБЕРІТЬ КОНТРАГЕНТА</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="sender">Оберіть місто:</label>
                    <input type="text" name="city" id="city" value="" placeholder="Пошук по назві міста">
                    <input type="hidden" name="cityRef" id="cityRef" value="">
                    <input type="hidden" name="cityArea" id="cityArea" value="">
                    <br><br>
                    <div style="overflow: auto; height: 300px; border-bottom: 2px solid #337ab7">
                        <div class="row">
                            <div id="cities-result-loader" class="col-md-2 col-md-offset-5" style="position: absolute; top: 50%; z-index: 9999;"></div>
                        </div>
                        <ul id="cities-result" class="list-group"></ul>
                    </div>
                    <br><br>
                </div>
                <div class="col-md-4">
                    <label for="counterparty">Оберіть контраг.:</label>
                    <input type="text" name="counterparty" id="counterparty" value="" placeholder="Пошук по назві контраг.">
                    <br><br>
                    <div id="counterparty-result-block" style="overflow: auto; height: 300px; border-bottom: 2px solid #337ab7">
                        <div class="row">
                            <div id="counterparty-result-loader" class="col-md-2 col-md-offset-5" style="position: absolute; top: 50%; z-index: 9999;"></div>
                        </div>
                        <ul id="counterparty-result" class="list-group"></ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="sender">Оберіть адресу:</label>
                    <input type="text" name="address" id="address" value="" placeholder="Пошук по назві адреси">
                    <br><br>
                    <div style="overflow: auto; height: 140px; border-bottom: 2px solid #337ab7">
                        <div class="row">
                            <div id="contact-address-result-loader" class="col-md-2 col-md-offset-5" style="position: absolute; top: 20%; z-index: 9999;"></div>
                        </div>
                        <ul id="contact-address-result" class="list-group"></ul>
                    </div>
                    <br>
                    <div style="overflow: auto; height: 140px; border-bottom: 2px solid #337ab7">
                        <div class="row">
                            <div id="address-result-loader" class="col-md-2 col-md-offset-5" style="position: absolute; top: 50%; z-index: 9999;"></div>
                        </div>
                        <ul id="address-result" class="list-group"></ul>
                    </div>
                    <br>
                    <label for="sender">Оберіть контактну особу:</label>
                    <input type="text" name="contact" id="contact" value="" placeholder="Пошук по контактній особі">
                    <br><br>
                    <div style="overflow: auto; height: 143px; border-bottom: 2px solid #337ab7">
                        <div class="row">
                            <div id="contact-result-loader" class="col-md-2 col-md-offset-5" style="position: absolute; top: 87%; z-index: 9999;"></div>
                        </div>
                        <ul id="contact-result" class="list-group"></ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
            <button id="submit" type="button" class="btn btn-success col-md-2 col-md-offset-4" data-dismiss="modal">Зберегти</button>
          <button type="button" class="btn btn-warning col-md-2" data-dismiss="modal">Відмінити</button>
        </div>
      </div>
      
    </div>
  </div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/jm.spinner.js') }}"></script> 
<script type="text/javascript">
    $.ajax({
        data: { _token: "{{csrf_token()}}" },
        type: "POST",
        url: "{{ URL::route('store.novaposhta.all_cities') }}",
        beforeSend: function() {
            $('#cities-result').empty();
            $('#cities-result-loader').jmspinner();
        },
        success: function(data) {
        $('#cities-result-loader').jmspinner(false);
        $('#cities-result').append(data);
        $('#cities-result li:first-child').find('a').addClass('active');
        }
    });

$(function() {
    $( "#counterparty" ).autocomplete({
        source: "{{ URL::route('store.novaposhta.autocomplete') }}",
        select: itemSelect,
        change: itemChange,
        response : response
    });
    function itemSelect(event, ui) {
      $('#counterparty-result').empty().append('<li><a href="#" class="list-group-item" data-ref="'+ui.item.ref+'" data-desc="'+ui.item.description+'">'+ui.item.form+' '+ui.item.description+' ('+ui.item.city+')</a></li>').find('li a').addClass('active');      
      var counterpartyRef = ui.item.ref;
      $.ajax({
          type: "POST",
          url: "select_contacts.php",
          data: ({ counterpartyRef : counterpartyRef }),
          beforeSend: function() {
              $('#contact-result').empty();
              $('#contact-result-loader').jmspinner();
          },
          success: function(data) {
              $('#contact-result-loader').jmspinner(false);
              $('#contact-result').empty();
              $('#contact-result').append(data);
              $('#contact-result li:first-child').find('a').addClass('active');
              $('#contact-result li').find('a').each(function(index) {
                  $(this).on("click", function(){
                      $('#contact-result li').find(".active").removeClass("active");
                      $(this).addClass("active");
                  });
              });
          }
      });
      //Підтягуємо всі адреси контрагента при його зміні (НЕ ПРАЦЮЄ)
      $.ajax({
          type: "POST",
          url: "select_contacts_address.php",
          data: ({ counterpartyRef : counterpartyRef }),
          beforeSend: function() {
              $('#contact-address-result').empty();
              $('#contact-address-result-loader').jmspinner();
          },
          success: function(data) {
              $('#contact-address-result-loader').jmspinner(false);
              $('#contact-address-result').empty();
              $('#contact-address-result').append(data);
              $('#contact-address-result li:first-child').find('a').addClass('active');
              if (!($('#contact-address-result li:first-child').find('a').hasClass('active'))) {
                  $('#address-result li').find('a').removeClass('active');
                  $('#address-result li:first-child').find('a').addClass('active');
              }
              else {
                  $('#address-result li').find('a').removeClass('active');
              }
              $('#contact-address-result li').find('a').each(function(index) {
                  $(this).on("click", function(){
                      $('#address-result li').find(".active").removeClass("active");
                      $('#contact-address-result li').find(".active").removeClass("active");
                      $(this).addClass("active");
                  });
              });
          }
      });

    }
    function itemChange(event, ui) {
        
    }
    function response(event, ui) {
      
    }        
});
</script>
@endsection