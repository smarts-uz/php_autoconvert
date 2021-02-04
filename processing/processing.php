<?php

// phpinfo();
// die();
//  6f37fbaa-d6fb-4be1-9c73-93eb4380a458


set_time_limit(0);
$diffTime= 50;


function redirect($url)
{
    echo <<<HTML
    <script> window.top.location.href = "{$url}";</script>
    HTML;

    echo <<<HTML
  <script> window.opener.location.href="{$url}";
        self.close();</script>
HTML;


}

function redirect_to_success($id)
{
    redirect("https://carplus.co.uk/quote/success/?acref=" . $id);
    // header("Location: https://carplus.co.uk/quote/success/?acref=" . $id);
    exit();
}

function redirect_back_with_message($message)
{
    redirect("https://carplus.co.uk/quote/?message=" . $message);
    // header("Location: https://carplus.co.uk/quote/?message=" . $message);
    exit();
}

function redirect_to_declined($id)
{
    redirect("http://carplus.co.uk/quote/declined?" . $id);
    // header("Location: http://carplus.co.uk/quote/declined?" . $id);
    exit();
    //echo 'declined';
}

function redirect_to_approved($id)
{
    redirect("http://carplus.co.uk/quote/approved?". $id);
    // header("Location: http://carplus.co.uk/quote/approved?". $id);
    exit();
    // echo 'approved';
}

function get_data()
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.autoconvert.co.uk/application/submit',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
		"VehicleType":"Car",
		"LoanAmount":20,
		"LoanTerm":20,
		"Products":[
			{
			"Name":"Cannot be null",
			"VAT":null,
			"NetValue":null,
			"CategoryId":null,
			"PaymentType":null
			}
		],
	"FinanceDetails":{
		"Deposit":null,
		"PartExchangeValue":null,
		"FDA":null,
		"EstimatedAnnualMileage":null,
		"Settlement":null,
		"EnquiryType":null,
		"FinanceTypeId":null
		},
	"BankDetails":{
		"SortCode":null,
		"AccountNumber":null,
		"AccountName":null,
		"TimeAtBankYears":null,
		"TimeAtBankMonths":null,
		"BranchName":null,
		"BankName":null,
		"BankAddress":null
		},
	"Vehicles":[
		{
			"Registration":null
		}
	],
	"Applicants":[
		{
			"Email":"test@test.co.uk",
			"Forename":"test",
			"Surname":"test"
		}
	]
	}',
        CURLOPT_HTTPHEADER => array(
            'X-ApiKey: 19ff541e-b45e-4ac5-8cda-dc457868211b',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
}

function check_for_approved()
{
    global $user_id;

    //  var_dump($user_id);
    // die;

    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.autoconvert.co.uk/application/' . $user_id);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'X-ApiKey: 19ff541e-b45e-4ac5-8cda-dc457868211b',
        'Content-Type: application/json'
    ));

    $result = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    //var_dump($result);
    $jsonArrayResponse = json_decode($result, true);
    if(array_key_exists('Message',$jsonArrayResponse)){
        redirect_back_with_message("No such id");
    }
    $data = $jsonArrayResponse['Enquiry']['EnquirySubStatusName'];
    $reference = $jsonArrayResponse['Enquiry']['Reference'];
    switch ($data) {
        case '1. Approved':
            redirect_to_approved($reference);
            break;

        case 'Declined':
            redirect_to_declined($reference);
            break;

        default:

    }

    return $reference;

}

function main()
{
    /*    while (true) {
            check_for_approved();
            print_r("not approved");
            sleep(2);
        }*/

    global $diffTime;
    $start_time = date('s');
    $end_time = date('s');

    while (abs($start_time - $end_time) < $diffTime) {
        $return = check_for_approved();
        $end_time = date('s');
        sleep(2);
    }    
    redirect_to_declined($return);

    //  redirect_to_declined($jsonArrayResponse['Reference']);

    // $jsonArrayResponse = get_data();
    // if($jsonArrayResponse['Accepted']){
    // 	print_r('Success');
    // 	redirect_to_success($jsonArrayResponse['Reference']);
    // }else{
    // 	print_r('Failure');
    // 	redirect_to_declined($jsonArrayResponse['Reference']);
    // }
}

main();
// redirect_to_success("27760789-7a7c-4a0f-bf12-fc57498a45f6");
?>


