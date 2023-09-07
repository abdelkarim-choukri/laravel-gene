<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\GeneData;

class GeneDataController extends Controller
{

public function index(Request $request){
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

public function uniqueGeneIds() {
    $uniqueGeneIds = GeneData::distinct()
        ->inRandomOrder()
        ->limit(40)
        ->pluck('gene_id')
        ->map(function ($geneId) {
            return [
                'value' => $geneId,
                'label' => $geneId,
            ];
        })->toArray();

    return response()->json($uniqueGeneIds);
}

public function uniqueSras(){
    // Query your database to retrieve unique SRA values
    $uniqueSras = GeneData::distinct()->pluck('SRA')->toArray();

    return response()->json($uniqueSras);
}
public function uniqueExpriments(){
    $uniqueExpriments = GeneData::distinct()->pluck('Expriment')->toArray();

    return response()->json($uniqueExpriments);
}


}
