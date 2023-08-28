<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allTransactionList()
    {
        
        try{
            //get all user transaction data
            
            Log::info('User transaction data get');

            $financeData = Finance::with('user')->orderBy('id','desc')->paginate(5);
           
            if($financeData){
                Log::info('User transaction data get');
                return response()->json(['status'=>true,'message'=>'','data'=>$financeData],200);
            }else{
                Log::warning('Data not found!');
                return response()->json(['success' => false,'message' => 'Data not found'], 400);
            } 

        }catch (ModelNotFoundException $ex) { // Finance not found
            Log::error('Finance Model Not found!');
            return response()->json(['status'=>false,'message'=>'Finance Model Not found!'],422);
        }catch (\Exception $e) {
            Log::error('something went wrong');
            return response()->json(['status'=>false,'message'=>'something went wrong'],500);
        }
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
           
            $validator = Validator::make($request->all(), [
                'transaction_id'  => 'required|numeric',  
            ]);
            
            if($validator->fails()){
                return response()->json(['success' => 'error','message' => 'Transaction id required'], 422);   
            }
    
            //delete finance data
            $financeData = Finance::where('id',$request->transaction_id)->first();

            Log::info('Check vaid User transaction data');

            if($financeData){
                $financeData->delete(); 

                Log::info('remove User transaction data');
                return response()->json(['status'=>true,'message'=>'User transaction data deleted successfully!'],200);
            }else{

                Log::warning('Data not found');
                return response()->json(['success' => false,'message' => 'Data not found'], 400);
            }

        }catch (ModelNotFoundException $ex) { // Finance not found
            Log::error('Finance Model Not found');
            return response()->json(['status'=>false,'message'=>'Finance Model Not found!'],422);
        } catch (\Exception $e) {
            Log::error('something went wrong!');
            return response()->json(['status'=>false,'message'=>'something went wrong!'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userTransactionDestroy(Request $request)
    {
        try {
           
            $validator = Validator::make($request->all(), [
                'user_id'  => 'required|numeric',  
            ]);
            
            if($validator->fails()){
                return response()->json(['success' => 'error','message' => 'User id required'], 422);  
            }
    
             //check user is valid or not

             Log::warning('User id invalid');

             $user = User::where('id',$request->user_id)->first();
             if(!$user){
                 return response()->json(['success' => 'error','message' => 'User id invalid'], 422);
             }
            //delete finance data
            $financeData = Finance::where('user_id',$request->user_id)->delete();

            Log::info('check user id valid data');

            if($financeData){
               
                Log::info('delete user data');
                return response()->json(['status'=>true,'message'=>'User transaction data deleted successfully!'],200);
            }else{

                Log::info('user not found');
                return response()->json(['success' => false,'message' => 'Data not found'], 400);
            }

        }catch (ModelNotFoundException $ex) { // Finance not found

            Log::error('Finance Model Not found');
            return response()->json(['status'=>false,'message'=>'Finance Model Not found!'],422);
        } catch (\Exception $e) {

            Log::error('something went wrong');
            return response()->json(['status'=>false,'message'=>'something went wrong!'],500);
        }
    }
}
