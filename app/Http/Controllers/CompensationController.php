<?php

namespace App\Http\Controllers;

use App\Models\Compensation;
use App\Models\Employee;
use App\Models\UploadCompensationdata;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CompensationController extends Controller
{

   

    public function index(){
        $compensation = Compensation::all();
        return ($compensation);
    }


    public function store(Request $request){
        try {
            $compensation = new Compensation();
            $compensation->age = $request->age;
            $compensation->industry = $request->industry;
            $compensation->role = $request->role;
            $compensation->annualSalary = $request->annualSalary;
            $compensation->currencyType = $request->currencyType;
            $compensation->loc = $request->loc;
            $compensation->yearOfExperince = $request->yearOfExperince;
            $compensation->additionalContents = $request->additionalContents;
            $compensation->other = $request->other;

            //H:i:s
            if ($compensation ->save()){
                return response()->json(['status'=> 'success', 'message' => 'Compensation submitted successfully ']);
            }
            
        }  
        catch (\Exception $e){
            return response()->json(['status'=> 'error', 'message' => $e->getMessage()]);
        }
    }


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

    function minComp($loc)
    {   
        $a=[];
        $result = Compensation::where('loc', 'LIKE', '%'. $loc. '%')->get('annualSalary');
        $result_array= json_decode($result, TRUE);
        $num=0;

        foreach ($result_array as $annualSalary)
        {
        $num++; 
        
        foreach ($annualSalary as $key=>$value)
        {
            
            $string = preg_replace('/[^0-9]/', '', $value);
            array_push($a,$string);
        }
       
        $minimum= min($a);
        // dd(gettype($a));
        }
        return "Minimum Compensation for ".$loc ." is -- $" . $minimum. "<br>" . $num. " total city(s) found";

    }

    function maxComp($loc)
    {   
        $a=[];
        $result = Compensation::where('loc', 'LIKE', '%'. $loc. '%')->get('annualSalary');
        $result_array= json_decode($result, TRUE);
        $num=0;

        foreach ($result_array as $annualSalary)
        {
        $num++; 
        
        foreach ($annualSalary as $key=>$value)
        {
            
            $string = preg_replace('/[^0-9]/', '', $value);
            array_push($a,$string);
        }
        $maximum = max($a);
        }
        return "Maximum Compensation for ".$loc ." is -- $" . $maximum . "<br>" . $num. " total city(s) found";

    }

    function averageComp($loc)
    {   
        $a=[];
        $result = Compensation::where('loc', 'LIKE', '%'. $loc. '%')->get('annualSalary');
        $result_array= json_decode($result, TRUE);
        $num=0;

        foreach ($result_array as $annualSalary)
        {
        $num++; 
        
        foreach ($annualSalary as $key=>$value)
        {
            
            $string = preg_replace('/[^0-9]/', '', $value);
            array_push($a,$string);


        }
        $a_count = count($a);
        $a_sum = array_sum($a);
        $mean_average = $a_sum / $a_count;
        }
        echo "Average Compensation for ".$loc ." is $" . $mean_average . "<br>" . $num. " total city(s) found";

    }
    
    public function destroy($id)
    {
        try {
            $compensation = Compensation::findOrFail($id);
            

            if ($compensation ->delete()){
                return response()->json(['status'=> 'success', 'message' => 'Compensation deleted  successfully ']);
            }
            
        }  
        catch (\Exception $e){
            return response()->json(['status'=> 'error', 'message' => $e->getMessage()]);
        }
    }

    public function importCompensationData(Request $request) {
        $data           =       array();

        $id = "";

        $file = $request->file("csv_file");
        $csvData = file_get_contents($file);

        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $header = array_shift($rows);

        foreach ($rows as $row) {

                    $compensationData = array(

                        "age" => $row["1"],
                        "industry" => $row["2"],
                        "role" => $row["3"],
                        "annualSalary" => $row["4"],
                        "currencyType" => $row["5"],
                        "loc" => $row["6"],
                        "yearOfExperince" => $row["7"],
                        "additionalContents" => $row["8"],
                        "other" => $row["9"],
                    );


                        $compensation = Compensation::create($compensationData);
                        if(!is_null($compensation)) {
                            $data["status"]     =       "success";
                            $data["message"]    =       "Leads imported successfully";
                        }                        

        }

        return $data["status"];
    }


    
function retriveComp($role)
    {   
        $a=[];
        $result = Compensation::where('role', 'LIKE', '%'. $role. '%')->get('annualSalary');
        $result_array= json_decode($result, TRUE);
        $num=0;

        foreach ($result_array as $annualSalary)
        {
        $num++; 
        
        foreach ($annualSalary as $key=>$value)
        {
            array_push($a,$value);
            return ($a) ;
        }
  
        }
    }

    public function pagiSortFil(Request $request)
    {
        $search =  $request->input('value');
        if($search!=""){
            $sorted = Compensation::where(function ($query) use ($search){
                $query->where('loc', 'like', '%'.$search.'%')
                    ->orWhere('currencyType', 'like', '%'.$search.'%')
                    ->orWhere('age', 'like', '%'.$search.'%');
            })
            ->paginate(50);
            $sorted->appends(['value' => $search]);
        }
        else{
            $sorted = Compensation::paginate(10);
        }
        return ($sorted);
    }

    public function sparce(Request $request)
    {
        $search =  $request->input('value');
        $search2 =  $request->input('value2');
        $search3 =  $request->input('value3');
        $search4 =  $request->input('value3');
        $search5 =  $request->input('value3');
        $a=[];
        $key = Compensation::findOrFail(1);
        $key= json_decode($key, TRUE);
        $num=0;

        foreach ($key as $val)
        {
        $num++; 
        // dd($key);
        
        foreach ($key as $keys=>$value)
        {
            array_push($a,$keys);
            
        }
        // dd ($a['1']) ;
        }

        if($search!=""){
            $result = Compensation::where($a['4'], 'LIKE', "%{$search}%")
                                    ->where($a['5'], 'LIKE', "%{$search2}%")
                                    ->where($a['6'], 'LIKE', "%{$search3}%")
                                    ->where($a['7'], 'LIKE', "%{$search4}%")->get();
            // $sorted->appends(['value' => $search]);
        }
        
        else{
            // $sorted = "Not found";
        }
        return ($result);
    }


}
