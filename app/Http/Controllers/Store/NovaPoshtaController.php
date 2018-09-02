<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

use NovaPoshta\ApiModels\Address; 
use NovaPoshta\ApiModels\Counterparty;
use NovaPoshta\ApiModels\InternetDocument;
use NovaPoshta\Models\CounterpartyContact;
use NovaPoshta\MethodParameters\InternetDocument_getDocumentList;
use NovaPoshta\MethodParameters\MethodParameters;
use NovaPoshta\MethodParameters\Counterparty_getCounterparties;
use NovaPoshta\MethodParameters\Counterparty_getCounterpartyAddresses;
use NovaPoshta\MethodParameters\Counterparty_getCounterpartyContactPersons;
use NovaPoshta\MethodParameters\Counterparty_getCounterpartyOptions;
use NovaPoshta\MethodParameters\Counterparty_getCounterpartyByEDRPOU;
use NovaPoshta\MethodParameters\Counterparty_cloneLoyaltyCounterpartySender;

use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Storekeeper;

class NovaPoshtaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:store');
    }

    public function index()
    {
        return view('store.novaposhta.index');
    }

    public function allCities()
    {
    	$data = new MethodParameters();

		$result = Address::getCities($data)->{'data'};

		$all_cities = array();

		foreach ($result as $item) {
		    $data = array();
		    $data['cityName'] = $item->{'Description'};
		    $data['cityRef'] = $item->{'Ref'};
		    array_push($all_cities, $data);
		    }

		foreach ($all_cities as $key => $value) {
		    if ($value['cityName'] == 'Вінниця') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		    elseif ($value['cityName'] == 'Дніпро') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		    elseif ($value['cityName'] == 'Київ') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		    elseif ($value['cityName'] == 'Львів') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		    elseif ($value['cityName'] == 'Одеса') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		    elseif ($value['cityName'] == 'Полтава') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		    elseif ($value['cityName'] == 'Харків') {
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		    }
		}
		echo '<li></li>';
		unset($all_cities[187], $all_cities[279], $all_cities[411], $all_cities[532], $all_cities[683], $all_cities[768], $all_cities[992]);
		foreach ($all_cities as $key => $value) {
		    echo '<li><a href="#" class="list-group-item" data-ref="'.$value['cityRef'].'">'.$value['cityName'].'</a></li>';
		}
    }

    public function selectCounterparties()
    {
        
    	$pageStart = Input::get('startPage');
		$pageStop = Input::get('stopPage');
		$cityRef = Input::get('cityRef');

		$final_array = array();

		$data = new MethodParameters();
		$data->CounterpartyProperty = 'Recipient';
		$data->Page = 1;
		$totalCount = Counterparty::getCounterparties($data)->{'info'};
		$pages = (round(($totalCount->{'totalCount'}  / 100), 0, PHP_ROUND_HALF_UP)) + 2;


		for ($i = 0 + $pageStart; $i < 1 + $pageStop; $i++) {
		// for ($i = 1; $i < $pages + 1; $i++) {
		    $data = new MethodParameters();
		    $data->CounterpartyProperty = 'Recipient';
		    $data->Page = $i;
		    $data->CityRef = $cityRef;
		    $result = Counterparty::getCounterparties($data)->{'data'};

		    foreach ($result as $item) {
		        $object = new stdClass();
		        $object->OwnershipFormDescription = $item->{'OwnershipFormDescription'};
		        $object->Description = $item->{'Description'};
		        $object->Ref = $item->{'Ref'};
		        $object->CityDescription = $item->{'CityDescription'};
		        array_push($final_array, $object);
		     
		    }
		}

		foreach ($final_array as $item) {
		    $form = $item->{'OwnershipFormDescription'};
		    $description = $item->{'Description'};
		    $ref = $item->{'Ref'};
		    $city = $item->{'CityDescription'};

		        if ($ref == '8a194abc-b021-11e7-becf-005056881c6b') {
		        echo '<li><strong>↓ фізичні особи ↓</strong><br><br></li>';
		        echo '<li><a href="#" class="list-group-item" data-ref="'.$ref.'">'.$description.'</a></li>';
		        echo '<li><br><strong>↓ юридичні особи ↓</strong><br><br></li>';
		    }

		        if ($ref !== '8a194abc-b021-11e7-becf-005056881c6b') {
		        echo '<li><a href="#" class="list-group-item" data-start="'.$pageStart.'" data-stop="'.$pageStop.'" data-ref="'.$ref.'" data-desc="'.$description.'">'.$form.' '.$description.' ('.$city.')</a></li>';
		    }
		}
    }

    public function selectContactsAddress()
    {

        $counterpartyRef = Input::get('counterpartyRef');

		$data = new MethodParameters();
		$data->Ref = $counterpartyRef;
		$data->CounterpartyProperty = 'Recipient';

		$result = Counterparty::getCounterpartyAddresses($data)->{'data'};

		if ($result) {
			foreach ($result as $item) {
			    $description = $item->{'Description'};
			    $ref = $item->{'Ref'};
			    	echo '<li><a href="#" class="list-group-item" data-ref="'.$ref.'">'.$description.'</a></li>';
			}
		}	

		else {
			echo '<div class="alert alert-danger" style="text-align: center">Адрес не знайдено</div>';
		}
			
		echo '<div style="text-align: center"><button type="button" id="add_address" class="btn btn-info">Додати адресу</button></div>';
        
    }

    public function selectContacts()
    {

        $counterpartyRef = Input::get('counterpartyRef');

		$data = new MethodParameters();
		$data->Ref = $counterpartyRef;

		$result = Counterparty::getCounterpartyContactPersons($data)->{'data'};

		foreach ($result as $item) {
		    $description = $item->{'Description'};
		    $ref = $item->{'Ref'};
		    $phones = $item->{'Phones'};
		    $lastName = $item->{'LastName'};
		    $firstName = $item->{'FirstName'};
		    $middleName = $item->{'MiddleName'};
		    echo '<li><a href="#" class="list-group-item" data-ref="'.$ref.'" data-phones="'.$phones.'" data-lastName="'.$lastName.'" data-firstName="'.$firstName.'" data-middleName="'.$middleName.'">'.$description.', тел. '.$phones.'</a></li>';
		}
        
    }

    public function selectOffice()
    {
        $city = Input::get('city');
        $cityRef = Input::get('cityRef');
        $counterpartyRef = Input::get('counterpartyRef');

		$data = new MethodParameters();
		$data->CityRef = $cityRef;

		$result = Address::getWarehouses($data)->{'data'};

		foreach ($result as $item) {
		    $name = $item->{'Description'};
		    $num = $item->{'Number'};
		    $ref = $item->{'Ref'};
		    echo '<li><a href="#" class="list-group-item" data-ref="'.$ref.'" data-number="'.$num.'">'.$name.'</a></li>';
		}
        
    }

    public function saveTtn()
    {
        
    	$payerType = Input::get('PayerType');
		$paymentMethod = Input::get('PaymentMethod');
		$volumeGeneral = Input::get('VolumeGeneral');
		$weight = Input::get('Weight');
		$seatsAmount = Input::get('SeatsAmount');
		$description = Input::get('Description');
		$cost = Input::get('Cost');
		$contactAddress = Input::get('ContactAddress');
		$recipientCityName = Input::get('RecipientCityName');
		$recipientAddressName = Input::get('RecipientAddressName');
		$recipientsPhone = Input::get('RecipientsPhone');
		$cityRecipient = Input::get('CityRecipient');
		$recipientRef = Input::get('RecipientRef');
		$contactRecipient = Input::get('ContactRecipient');
		$dateTime = Input::get('DateTime');
		$backDelivPayerType = Input::get('BackDelivPayerType');
		$backDelivCargoType = Input::get('BackDelivCargoType');
		$backDelivString = Input::get('BackDelivString');

		$sender = new CounterpartyContact();
		$sender->setCity('9f123288-3c30-11e5-add9-005056887b8d');
		$sender->setRef('063a4803-e065-11e5-899e-005056887b8d');
		$sender->setAddress('12ae53a8-40f6-11e5-8d8d-005056887b8d');
		$sender->setContact('7e31e439-e113-11e5-a70c-005056801333');
		$sender->setPhone('380958219250');

		$recipient = new CounterpartyContact();
		$recipient->setCity($cityRecipient);
		$recipient->setRef($recipientRef);
		if ($contactAddress !== '') {
		   $recipient->setAddress($contactAddress);
		}
		$recipient->setContact($contactRecipient);
		$recipient->setPhone($recipientsPhone);

		if (isset($backDelivCargoType) && $backDelivCargoType == 'Money') {
		   $backwardDeliveryData = new \NovaPoshta\Models\BackwardDeliveryData();
		   $backwardDeliveryData->setPayerType($backDelivPayerType);
		   $backwardDeliveryData->setCargoType($backDelivCargoType);
		   $backwardDeliveryData->setRedeliveryString($backDelivString);
		}


		$internetDocument = new InternetDocument();
		$internetDocument->setSender($sender);
		$internetDocument->setRecipient($recipient);
		if (isset($contactAddress)) {
		   $internetDocument->setServiceType('WarehouseDoors');
		}
		else {
		   $internetDocument->setServiceType('WarehouseWarehouse');
		   $internetDocument->setNewAddress('1');
		}
		$internetDocument->setPayerType($payerType);
		$internetDocument->setPaymentMethod($paymentMethod);
		$internetDocument->setCargoType('Cargo');
		$internetDocument->setWeight($weight);
		$internetDocument->setVolumeGeneral($volumeGeneral);
		$internetDocument->setSeatsAmount($seatsAmount);
		$internetDocument->setCost($cost);
		$internetDocument->setDescription($description);
		$internetDocument->setDateTime($dateTime);
		$internetDocument->setRecipientCityName($recipientCityName);
		$internetDocument->setRecipientArea('');
		if (!(isset($contactAddress))) {
		   $internetDocument->setRecipientAddressName($recipientAddressName);
		}
		$internetDocument->setRecipientHouse('');
		$internetDocument->setRecipientFlat('');
		if (isset($backDelivCargoType) && $backDelivCargoType == 'Money') {
		   $internetDocument->addBackwardDeliveryData($backwardDeliveryData);
		}

		$result = $internetDocument->save();
		$success = $result->{'data'};
		$errors = $result->{'errors'};

		if ($errors) {   
		   foreach ($errors as $error) {
		      $data = array();
		      $data['error'] = $error;
		      }
		}
		else {
		   foreach ($success as $item) {
		      $data = array();
		      $data['IntDocNumber'] = $item->{'IntDocNumber'};
		      $data['CostOnSite'] = $item->{'CostOnSite'};
		   }
		   
		}
		return response()->json($data);
        
    }

    public function printTtn()
    {
        
        $ttnNumber = Input::get('ttnNumber');

		if (isset($ttnNumber)) {
			$data = new \NovaPoshta\MethodParameters\InternetDocument_printDocument();

			$data->addDocumentRef($ttnNumber);
			$data->setType(InternetDocument::PRINT_TYPE_PDF);
			$result =  InternetDocument::printMarkings($data);

			file_put_contents("TTN_NewMark.pdf", fopen($result, 'r'));
			rename("TTN_NewMark.pdf", "split/result/TTN_NewMark.pdf");
		}
        
    }

    public function autocomplete()
    {

    	$searchTerm = Input::get('term');
    	//$searchTerm = 'коваленко';

		$data = new MethodParameters();
		$data->CounterpartyProperty = 'Recipient';
		$data->Page = 1;
		$data->FindByString = $searchTerm;

		$result = Counterparty::getCounterparties($data)->{'data'};

		foreach ($result as $item) {
		    //$object = new stdClass();
		    $ownership = $item->{'OwnershipFormDescription'};
		    $description = $item->{'Description'};
		    $ref = $item->{'Ref'};
		    $cityRef = $item->{'City'};
		    $cityDescription = $item->{'CityDescription'};

		    $users[] = array("ref" => $ref, "value" => $ownership.' '.$description.' ('.$cityDescription.')', "city" => $cityDescription, "form" => $ownership, "description" => $description);
		    
		  
		}
		return Response::json($users);
    }
}
