<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Stripe\Stripe;



class StripeCustomClass extends Controller
{
    public function testclass($val){
    	return $val.' df';
    }

    public function __construct(){
		$account = Stripe::setApiKey(env('STRIPE_TEST_SECRET_API_KEY'));
    }

    public function createCustomer($email,$description = ''){
    	try {		
				$description = !empty($description) ? 'Customer for Project': $description;
				$customer = \Stripe\Customer::create(array(
					  "description" => $description,
					  "email" => $email,
				));
				$data['status'] = 1;
				$data['stripe_customer_id'] = $customer->id;
			} catch(\Stripe\Error\Card $e) {
				$body = $e->getJsonBody();
				$err  = $body['error'];
				$data['status'] = 2;
				$data['error'] = $err['message'];
			} catch (\Stripe\Error\RateLimit $e) {
			 	$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\InvalidRequest $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\Authentication $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\ApiConnection $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\Base $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (Exception $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			}
		return $data;
    }

    public function addCreditCard($stripe_customer_id,$token_id){
    	try {
			$customer = Stripe\Customer::retrieve($stripe_customer_id);
			$customer->sources->create(array("source" => $token_id));
			$customer->save();
			$data['status'] = 1;
			$data['card_id'] = $customer->default_source;
		} catch(\Stripe\Error\Card $e) {
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$data['status'] = 2;
			$data['error'] = $err['message'];
		} catch (\Stripe\Error\RateLimit $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (Exception $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		}
		return $data;
    }

    public function deleteCreditCard($stripe_customer_id,$card_id){
    	try {
			$customer = Stripe\Customer::retrieve($stripe_customer_id);
			$customer->sources->retrieve($card_id)->delete();
			$customer->save();
			$data['status'] = 1;
		} catch(\Stripe\Error\Card $e) {
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$data['status'] = 2;
			$data['error'] = $err['message'];
		} catch (\Stripe\Error\RateLimit $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\InvalidRequest $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		} catch (Exception $e) {
			$data['status'] = 2;
			$data['error'] = $e->getMessage();
		}
		return $data;
    }

    public function createCreditCardPayment($stripe_customer_id,$amount,$receipt_email,$orderId,$card_id = ''){
    	try {	

				$charge = \Stripe\Charge::create(array(
				  "amount" => $amount*100, // cent
				  "currency" => "usd",
				  "customer" => $stripe_customer_id,
				  "receipt_email" => $receipt_email,
				  "transfer_group" => "{".$orderId."}",
				));
				$data['status'] = 1;
				$data['transacation_id'] = $charge->id;
			} catch(\Stripe\Error\Card $e) {
				$body = $e->getJsonBody();
				$err  = $body['error'];
				$data['status'] = 2;
				$data['error'] = $err['message'];
			} catch (\Stripe\Error\RateLimit $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\InvalidRequest $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\Authentication $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\ApiConnection $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\Base $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (Exception $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			}
		return $data;
    }

    public function transferAmountToMerchant($stripe_customer_id,$amount,$stripe_merchant_id,$orderId,$card_id = ''){
    	try {	

				$transfer = \Stripe\Transfer::create(array(
					  "amount" => $amount * 100, // cent,
					  "currency" => "usd",
					  "destination" => $stripe_merchant_id,
					  "transfer_group" => "{$orderId}"
					));
				$data['status'] = 1;
				$data['transacation_id'] = $transfer->id;
			} catch(\Stripe\Error\Card $e) {
				$body = $e->getJsonBody();
				$err  = $body['error'];
				$data['status'] = 2;
				$data['error'] = $err['message'];
			} catch (\Stripe\Error\RateLimit $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\InvalidRequest $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\Authentication $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\ApiConnection $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (\Stripe\Error\Base $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			} catch (Exception $e) {
				$data['status'] = 2;
				$data['error'] = $e->getMessage();
			}
		return $data;
    }


}
