<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\GeneData;

class GeneDataController extends Controller
{
    // public function index(Request $request)
    // {
    //     // You can filter data based on the user's selections here
    //     $query = GeneData::query();

    //     if ($request->has('gene_id')) {
    //         $query->where('gene_id', $request->input('gene_id'));
    //     }

    //     if ($request->has('Disease')) {
    //         $query->where('Disease', $request->input('Disease'));
    //     }

    //     if ($request->has('Expriment')) {
    //         $query->where('Expriment', $request->input('Expriment'));
    //     }

    //     if ($request->has('SRA')) {
    //         $query->where('SRA', $request->input('SRA'));
    //     }

    //     $geneData = $query->get();

    //     return response()->json($geneData);
    //     // return GeneData::all();
    // }

//     public function index(Request $request){
//     // You can filter data based on the user's selections here
//     $query = GeneData::query();

//     if ($request->has('gene_id')) {
//         $query->whereIn('gene_id', (array)$request->input('gene_id'));
//     }

//     if ($request->has('Disease')) {
//         $diseaseValues = (array)$request->input('Disease');
//         if (!in_array('all', $diseaseValues)) {
//             $query->whereIn('Disease', $diseaseValues);
//         }
//     }

//     if ($request->has('Expriment')) {
//         $exprimentValues = (array)$request->input('Expriment');
//         if (!in_array('all', $exprimentValues)) {
//             $query->whereIn('Expriment', $exprimentValues);
//         }
//     }

//     if ($request->has('SRA')) {
//         $query->whereIn('SRA', (array)$request->input('SRA'));
//     }

//     // Select all the required columns for the heatmap
//     $geneData = $query->select('SRA', 'Expriment', 'Disease', 'gene_id', 'value')->get();

//     // Prepare the data for the heatmap
//     $heatmapData = [];
//     foreach ($geneData as $data) {
//         $heatmapData[] = [
//             'SRA' => $data->SRA,
//             'Expriment' => $data->Expriment,
//             'Disease' => $data->Disease,
//             'gene_id' => $data->gene_id,
//             'value' => $data->value,
//         ];
//     }

//     return response()->json($heatmapData);
// }

public function index(Request $request)
{
    $query = GeneData::query();

    if ($request->has('gene_id')) {
        $geneIds = (array) $request->input('gene_id');
        $query->whereIn('gene_id', $geneIds);
    }

    // ... (add more conditions for other variables if needed)

    $geneData = $query->select('SRA', 'Expriment', 'Disease', 'gene_id', 'value')
        ->groupBy('SRA', 'Expriment', 'Disease', 'gene_id', 'value')
        ->get();

    // Prepare the data for the heatmap
    $heatmapData = $geneData->map(function ($data) {
        return [
            'SRA' => $data->SRA,
            'Expriment' => $data->Expriment,
            'Disease' => $data->Disease,
            'gene_id' => $data->gene_id,
            'value' => $data->value,
        ];
    });

    return response()->json($heatmapData);
}


}
