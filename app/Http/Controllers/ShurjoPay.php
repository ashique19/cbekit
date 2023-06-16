<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShurjoPay extends Controller
{
    

    public function initialize($courseId)
    {
    
        $ch = curl_init();
        $options = array( 'Merchant_Username'=>'spaytest', 'Merchant_password'=>'pass1234');
        $uniq_transaction_key = 'NOK'.uniqid();//Given By Shurjumukhi Limited
        $amount = 0.10;
        $clientIP = '127.0.0.1';
        // $clientIP = $_SERVER['REMOTE_ADDR'];

        $xml_data = 'spdata=<?xml version="1.0" encoding="utf-8"?>
                                <shurjoPay><merchantName>'.$options['Merchant_Username'].'</merchantName>
                                <merchantPass>'.$options['Merchant_password'].'</merchantPass>
                                <userIP>'.$clientIP.'</userIP>
                                <uniqID>'.$uniq_transaction_key.'</uniqID>
                                <totalAmount>'.$amount.'</totalAmount>
                                <paymentOption>shurjopay</paymentOption>
                                <returnURL>'.action('StudentCourses@updateToPremium', [$courseId,'_token' => csrf_token() ]).'</returnURL></shurjoPay>';


        $url = "https://shurjotest.com/sp-data.php";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST, 1);               
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close ($ch);

        return $response;
    
    }


    public function returnData($data)
    {

        $response_encrypted = $data;
        
        $fp = fopen('shurjopay.txt', 'a');
        $e = $response_encrypted."\n";
        fwrite($fp,$response_encrypted);
        fclose($fp);
        
        $response_decrypted = file_get_contents("https://shurjotest.com/merchant/decrypt.php?data=".$response_encrypted);
        $data= simplexml_load_string($response_decrypted) or die("Error: Cannot create object");

        $fp = fopen('shurjopay.txt', 'a');
        $d = $response_decrypted."\n";
        fwrite($fp,$response_decrypted);
        fclose($fp);
        
        // return $data;
	
		$tx_id = $data->txID;
		$bank_tx_id = $data->bankTxID;
		$bank_status = $data->bankTxStatus;
		$sp_code = $data->spCode;
		$sp_code_des = $data->spCodeDes;
		$sp_payment_option = $data->paymentOption;

		switch($sp_code) {
			case '000':
				$res = array('status'=>true,'msg'=>'success');
				break;
			case '001':
				$res = array('status'=>false,'msg'=>'Transaction failed');
				break;            
			default:
				$res = array('status'=>false,'msg'=>'Unknow Error Occured.');
				break;            
		}


        if($res['status']) {
            echo "Success";          
            header("location:".$success_url."?status=success&msg=".$res['msg']."&id=".$tx_id);
                die();
        } else {
            header("location:".$failed_url."?status=failed&msg=".$res['msg']."&id=".$tx_id);
            die();
        }
    
    
    }


}
