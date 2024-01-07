<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindDuplicatesController extends Controller
{
    public function findDuplicates(Request $request)
    {
        $inputData = $request->json()->all();

        // Ensure that the 'N' key exists in the request data
        if (!isset($inputData['N']) || !isset($inputData['a'])) {
            return response()->json(['error' => 'Invalid input. N and a keys are required.'], 400);
        }

        try{

            $N = $inputData['N'];
            $a = $inputData['a'];
            
            $countedValues = array_count_values($a);
            $duplicates = [];
            
            foreach ($countedValues as $value => $count) {
                if ($count > 1) {
                    $duplicates[] = $value;
                }
            }
            
            return response()->json($duplicates);
            
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
