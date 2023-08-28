<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'user_id'  => 'required|numeric',  
            ]);
            
            if($validator->fails()){
                return response()->json(['success' => 'error','message' => 'User id required'], 422);
            }
            
             //check user is valid or not
            $user = User::where('id',$request->user_id)->first();
            if(!$user){
                Log::warning('User id invalid!');
                return response()->json(['success' => 'error','message' => 'User id invalid'], 422);
            }

            //get all user transaction data
            Log::info('User transaction data get');

            $financeData = Finance::with('user')->where('user_id',$request->user_id)->paginate(5);
            if(!$financeData){

                Log::warning('Data not found!');

                return response()->json(['success' => false,'message' => 'Data not found'], 400);
            }else{

                Log::info('User transaction data get');
                return response()->json(['status'=>true,'message'=>'','data'=>$financeData],200);
               
            } 
            

        }catch (ModelNotFoundException $ex) { // Finance not found
            Log::error('Finance Model Not found!');
            return response()->json(['status'=>false,'message'=>'Finance Model Not found!'],422);
        }catch (\Exception $e) {
            Log::error('something went wrong!');
            return response()->json(['status'=>false,'message'=>'something went wrong!'],500);
        }
        
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           
            $validator = Validator::make($request->all(), [
                'account_name'            => 'required|max:100',
                'account_number'          => 'required|numeric|digits_between:10,20',
                'account_balance'         => 'required|numeric|digits_between:1,100|gt:0',
                'transaction_description' => 'required|max:250',
                'transaction_amount'      => 'required|numeric|digits_between:1,100|gt:0',
                'transaction_date'        => 'required|date',
                'transaction_month'       => 'required|string|max:50',
                'transaction_year'        => 'required|numeric|digits_between:1,4',
               
            ]);
            
            if($validator->fails()){
                return response()->json(['Errors.', $validator->errors()],422);       
            }
            
            Log::info('Store user fianance transaction data');
            //store finance data
            $finance                           = new Finance();
            $finance->user_id                  = Auth::id(); 
            $finance->account_name             = $request->account_name; 
            $finance->account_number           = $request->account_number;
            $finance->account_balance          = $request->account_balance;
            $finance->transaction_description  = $request->transaction_description;
            $finance->transaction_amount       = $request->transaction_amount;
            $finance->transaction_date         = date('Y-m-d',strtotime($request->transaction_date));
            $finance->transaction_month        = $request->transaction_month;
            $finance->transaction_year         = $request->transaction_year;
            $finance->save();
           
            if($finance->save()){
                Log::info('User transaction data added successfully!');

                return response()->json(['status'=>true,'message'=>'User transaction data added successfully!'],200);
            }else{

                Log::warning('User transaction data not added!');
                return response()->json(['success' => false,'message' => 'User transaction data not added!'], 400);
            }
            
        }catch (ModelNotFoundException $ex) { // Finance not found
            Log::error('Finance Model Not found!');
            return response()->json(['status'=>false,'message'=>'Finance Model Not found!'],422);
        } catch (\Exception $e) {
            Log::error('something went wrong!');
            return response()->json(['status'=>false,'message'=>'something went wrong!'],500);
        }
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
           
            $validator = Validator::make($request->all(), [
                'account_name'            => 'required|max:100',
                'account_number'          => 'required|numeric|digits_between:10,20',
                'account_balance'         => 'required|numeric|digits_between:1,100',
                'transaction_description' => 'required|max:250',
                'transaction_amount'      => 'required|numeric|digits_between:0,100|gt:0',
                'transaction_date'        => 'required|date',
                'transaction_month'       => 'required|string|max:50',
                'transaction_year'        => 'required|numeric|digits_between:1,4',
               
            ]);
            
            if($validator->fails()){
                return response()->json(['Errors.', $validator->errors()],422);       
            }
    
            //update finance data
            $finance     = Finance::where('id',$id)->first();
            Log::info('Check user tarnsaction already store data');

            if($finance){
                $finance->account_name             = $request->account_name; 
                $finance->account_number           = $request->account_number;
                $finance->account_balance          = $request->account_balance;
                $finance->transaction_description  = $request->transaction_description;
                $finance->transaction_amount       = $request->transaction_amount;
                $finance->transaction_date         = date('Y-m-d',strtotime($request->transaction_date));;
                $finance->transaction_month        = $request->transaction_month;
                $finance->transaction_year         = $request->transaction_year;
                $finance->save();

                if($finance->save()){

                    Log::info('User transaction data updated successfully!');

                    return response()->json(['status'=>true,'message'=>'User transaction data updated successfully!'],200);
                }else{

                    Log::warning('User transaction data not updated');
                    return response()->json(['success' => false,'message' => 'User transaction data not updated'], 400);
                }
                
            }else{
                Log::error('Data not found');
                return response()->json(['success' => false,'message' => 'Data not found'], 400);
            }
            

        } catch (ModelNotFoundException $ex) { // Finance not found
            Log::error('Finance Model Not found!');
            return response()->json(['status'=>false,'message'=>'Finance Model Not found!'],422);
        }catch (\Exception $e) {
            Log::error('something went wrong!');
            return response()->json(['status'=>false,'message'=>'something went wrong!'],500);
        }
    }

    
}
