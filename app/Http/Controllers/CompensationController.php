<?php

namespace App\Http\Controllers;

use App\Models\Compensation;
use Illuminate\Http\Request;

class CompensationController extends Controller

{   
    //Get all Compensation Data
    public function index(){
        $compensation = Compensation::all();
        return ($compensation);
    }

        // Add new compensation data to existing record via POST request
    public function store(Request $request){
        try {
            //instantiate
            $compensation = new Compensation();

            //load requests accordingly
            $compensation->age = $request->age;
            $compensation->industry = $request->industry;
            $compensation->role = $request->role;
            $compensation->annualSalary = $request->annualSalary;
            $compensation->currencyType = $request->currencyType;
            $compensation->loc = $request->loc;
            $compensation->yearOfExperince = $request->yearOfExperince;
            $compensation->additionalContents = $request->additionalContents;
            $compensation->other = $request->other;
            
            //save to db
            if ($compensation ->save()){
                return response()->json(['status'=> 'success', 'message' => 'Compensation submitted successfully ']);
            }   
        }  
        catch (\Exception $e){
            return response()->json(['status'=> 'error', 'message' => $e->getMessage()]);
        }
    }


//Update the details of an existing compensation data
    public function update(Request $request, $id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            $compensation->age = $request->age;
            $compensation->industry = $request->industry;
            $compensation->role = $request->role;
            $compensation->annualSalary = $request->annualSalary;
            $compensation->currencyType = $request->currencyType;
            $compensation->loc = $request->loc;
            $compensation->yearOfExperince = $request->yearOfExperince;
            $compensation->additionalContents = $request->additionalContents;
            $compensation->other = $request->other;

            if ($compensation ->save()){
                return response()->json(['status'=> 'success', 'message' => 'Compensation updated successfully ']);
            }
            
        }  
        catch (\Exception $e){
            return response()->json(['status'=> 'error', 'message' => $e->getMessage()]);
        }
    }


    //Retrieve the average, minimum, and maximum compensation per city
    function minMaxAvgcomp(Request $request)
    {   
      
        $loc = $request->loc;
        $validator= $this->validate(
            $request, [
                'loc' => 'required',
            ]
         );
         if ($validator != True) {
            return redirect($request->path()) // or some path
                ->withErrors($validator)
                ->withInput();
        }
        else{
        $a=[];
        $result = Compensation::where('loc', 'LIKE', '%'. $loc. '%')->get('annualSalary');
        $result_array= json_decode($result, TRUE);
        $num=0;
            foreach ($result_array as $annualSalary)
            {
                //counter
                $num++; 
                
                foreach ($annualSalary as $key=>$value)
                {
                    //remove unwanted char
                    $string = preg_replace('/[^0-9]/', '', $value);
                    array_push($a,$string);
                } 
                //using the Min function
                $minimum= min($a); 
                
                //using max function
                $maximum=max($a);

                //calculate avg
                $a_count = count($a);
                $a_sum = array_sum($a);
                $mean_average = $a_sum / $a_count;
            }
            
            return response()->json($loc= [
                                    'minimum'=> $minimum, 
                                    'Maximum' =>$maximum, 
                                    'Average'=>$mean_average],);
    }
        
        // catch (\Exception $e){
        //     return response()->json(['status'=> 'error', 'message' =>$e->getMessage() . " or " . "please check spelling"]);
        // }
    }


//Retrieve the average compensation for a given role or roles.
    function avgCompRole($role)
    {   
        $a=[];
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~','20', '%'];

        //replace resevered strings, to make word searchable
        $role = str_replace($reservedSymbols, '%', $role);
        
        //search $role and return its annual salary
        $result = Compensation::where('role', 'LIKE', '%'. $role. '%')->get('annualSalary');
        
        //decode to json
        $result_array= json_decode($result, TRUE);
        $num=0;

        try{
        foreach ($result_array as $annualSalary)
        {
            $num++; 
            
            foreach ($annualSalary as $key=>$value)
            {     
                // $string = preg_replace('/[^0-9]/', '', $value);
                array_push($a,$value);
            }
            $a_count = count($a);
            $a_sum = array_sum($a);
            $mean_average_role = $a_sum / $a_count;

            //replace % with empty space eg office%manager----office manager
            $role = str_replace($reservedSymbols, ' ', $role);
        }
        
        return response()->json($role=['Role'=> $role, 'Count' =>$a_count, 'Average'=>$mean_average_role]);

        }
        //catch errors and return
            catch (\Exception $e){
                return response()->json(['status'=> 'error', 'message' =>$e->getMessage() . " or " . "please check spelling"]);
        }
    }


 //List compensation data via API GET request with the ability to paginate data, and filter and sort or more fields/attributes
    public function paginateFilt(Request $request)
    {
        try{
            $search0 =  $request->input('city');
            $search1 =  $request->input('currencyType');
            $search2 =  $request->input('role');
            //$search3 =  $request->input('value');
            //$search =  $request->input('value');
            if($search0!=""){
                $sorted = Compensation::where(function ($query) use ($search0, $search1, $search2){
                    $query->where('loc', 'like', '%'.$search0.'%')
                        ->Where('currencyType', 'like', '%'.$search1.'%')
                        ->Where('role', 'like', '%'.$search2.'%');
                })
                //argument 10(10 entries per page)
                ->paginate(10);
                $sorted->appends(['value' => 'data']);
            }
            else{
                    $sorted = Compensation::paginate(10);
            }
            return ($sorted);
        }
        catch (\Exception $e){
            return response()->json(['status'=> 'error', 'message' => $e->getMessage() . " or " . "please check spelling"]);
        }
    }


//Fetch a single record via GET request. Return a sparce fieldset (e.g. /compensation_data?fields=first_name,last_name,salary)
    public function sparce(Request $request)
    {
        //requested search fields
        $search0 =  $request->input('value');
        $search1 =  $request->input('value2');
        $search2 =  $request->input('value3');
        $search3 =  $request->input('value4');
        $search4 =  $request->input('value5');
        $search5 =  $request->input('value6');

        //loads them into an array
        $array=[$search0, $search1, $search2, $search3, $search4, $search5];
        //filter empty fields
        $searchValues = array_filter($array);
              
        // load and search through DB, return data with rows
        $result = Compensation::select($searchValues)->get();
                
        //return ($result);
        return $result;
                                
    }
//sort
    public function sortRequest(Request $request)
    {

        //requested sort fields
        $sortWord =  $request->input('sortWord');
        $switch =  $request->input('value');
        if ($sortWord !=''){

            //check through using $softword to sort, $switch btw asce and desc
            $result = Compensation::orderBy($sortWord, $switch)->get();
                    
            //return ($result);
            return $result;
        }                      
    }

//Upload compensation data via POST request
    public function importCompensationData(Request $request) {
        $compensationData=array();
        // $id = "";
        $file = $request->file("csv_file");
        if ($file) {
        $csvData = file_get_contents($file);

        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);
// dd($rows);
        foreach ($rows as $row) {
                // try{
                    dd($row);
                        $j = 1;
                        $compensationData = array(
                        "employee_id"=>strval($j),
                        "timeUploaded"=>,
                        "age" =>$row,
                        "industry" =>$row,
                        "role" =>$row["3"],
                        "annualSalary" =>preg_replace('/[^0-9]/', '', $row["4"]),
                        "currencyType" =>$row["5"],
                        "loc" =>$row["6"],
                        "yearOfExperince" =>$row["7"],
                        "additionalContents" =>$row["8"],
                        "other" =>$row["9"],
                       
                    );

                        $compensationData = array_filter($compensationData);
                        $j++;
                    // dd ($compensationData);
                        $compensation = Compensation::create($compensationData);
                    
                        
                            //throw $th;
                        }
                            return response()->json([
                                'message' => "$j records successfully uploaded"
                                ]);
                        // if(!is_null($compensation)) {
                        //     $data["status"]     =       "success";
                        //     $data["message"]    =       "Data imported successfully";
                        // }  
                    }  
                }                    
        //    catch (\Exception $e) {return response()->json(['status'=> 'error', 'message' => 'there was an error']);
        //                 }

                        // else {
                        //     //no file was uploaded
                        //     return ('No file was uploaded');
                        //     }
                         
}
    // public function importCompensationData(Request $request) {
    //     $data=array();

    //     $id = "";

    //     $file = $request->file("csv_file");
    //     $csvData = file_get_contents($file);

    //     $rows = array_map("str_getcsv", explode("\n", $csvData));
    //     $header = array_shift($rows);

    //     foreach ($rows as $row) {

    //                 $compensationData = array(
    //                     "age" => $row["1"],
    //                     "industry" => $row["2"],
    //                     "role" => $row["3"],
    //                     "annualSalary" => $row["4"],
    //                     "currencyType" => $row["5"],
    //                     "loc" => $row["6"],
    //                     "yearOfExperince" => $row["7"],
    //                     "additionalContents" => $row["8"],
    //                     "other" => $row["9"],
    //                 );
    //                     $compensation = Compensation::create($compensationData);
    //                     if(!is_null($compensation)) {
    //                         $data["status"]     =       "success";
    //                         $data["message"]    =       "Data imported successfully";
    //                     }                        
    //     }

    //     return $data["status"];
    


