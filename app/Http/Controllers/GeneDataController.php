<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\GeneData;

class GeneDataController extends Controller
{


public function index(Request $request)
{
    $query = GeneData::query();

    if ($request->has('gene_id')) {
        $geneIds = (array) $request->input('gene_id');
        $query->whereIn('gene_id', $geneIds);
    }

    if ($request->has('disease')) {
        $disease = $request->input('disease');
        $query->where('Disease', $disease);
    }

    if ($request->has('expriment')) {
        $expriment = $request->input('expriment');
        $query->where('Expriment', $expriment);
    }

    if ($request->has('sra')) {
        $expriment = $request->input('sra');
        $query->where('SRA', $expriment);
    }

    // ... (add more conditions for other variables if needed)

    $geneData = $query->select('SRA', 'Expriment', 'Disease', 'gene_id', 'value', 'Abbreviation')
        ->groupBy('SRA', 'Expriment', 'Disease', 'gene_id', 'value', 'Abbreviation')
        ->get();

    // Convert the collection to a standard indexed array and sort it by 'Abbreviation'
    $geneDataArray = $geneData->toArray();
    usort($geneDataArray, function ($a, $b) {
        return strcmp($a['Abbreviation'], $b['Abbreviation']);
    });

    // Convert the sorted array back to an associative array if needed
    // $sortedGeneData = collect($geneDataArray);

    // Prepare the data for the heatmap
    // $heatmapData = $sortedGeneData->map(function ($data) {
    //     return [
    //         'SRA' => $data['SRA'],
    //         'Expriment' => $data['Expriment'],
    //         'Disease' => $data['Disease'],
    //         'gene_id' => $data['gene_id'],
    //         'value' => $data['value'],
    //         'Abbreviation' => $data['Abbreviation'],
    //     ];
    // });

    return response()->json($geneDataArray);
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
public function uniqueAbbreviation(Request $request){
    // Retrieve the selected filters from the request
    $selectedGeneIds = $request->input('gene_id');
    $selectedDisease = $request->input('disease');
    $selectedExpriment = $request->input('expriment');
    $selectedSra = $request->input('sra');

    // Start building the query
    $query = GeneData::query();

    // Add filters to the query as needed
    if ($selectedGeneIds) {
        $query->whereIn('gene_id', $selectedGeneIds);
    }

    if ($selectedDisease) {
        $query->where('disease', $selectedDisease);
    }

    if ($selectedExpriment) {
        $query->where('expriment', $selectedExpriment);
    }

    if ($selectedSra) {
        $query->where('sra', $selectedSra);
    }

    // Retrieve unique 'Abbreviation' values based on the filtered query
    $uniqueAbbreviation = $query->distinct()->pluck('Abbreviation')->toArray();

    return response()->json($uniqueAbbreviation);
}

public function uniqueExpriments(){
    $uniqueExpriments = GeneData::distinct()->pluck('Expriment')->toArray();

    return response()->json($uniqueExpriments);
}

public function getPossibleDiseases(Request $request){
    // Check if 'gene_id' query parameter is provided
    if ($request->has('gene_id')) {
        $geneIds = $request->input('gene_id');
        
        // Use $geneIds to filter diseases for specific genes
        // You would typically query your database here
        $diseases = GeneData::whereIn('gene_id', $geneIds)->distinct()->pluck('disease');
    } else {
        // If 'gene_id' is not provided, consider all genes
        // Query your database for all diseases here
        $diseases = GeneData::distinct()->pluck('disease');
    }

    return response()->json($diseases);
}

public function getPossibleExpriments(Request $request)
{
    // Check if 'gene_id' and 'disease' query parameters are provided
    if ($request->has('gene_id') && $request->has('disease')) {
        $geneIds = $request->input('gene_id');
        $disease = $request->input('disease');
        
        // Use $geneIds and $disease to filter expriments for specific genes and disease
        // You would typically query your database here
        $expriments = GeneData::whereIn('gene_id', $geneIds)
            ->where('disease', $disease)
            ->distinct()
            ->pluck('expriment');
    } else {
        // If 'gene_id' and 'disease' are not provided, consider all expriments
        // Query your database for all expriments here
        $expriments = GeneData::distinct()->pluck('expriment');
    }

    return response()->json($expriments);
}


public function getPossibleSras(Request $request){
    // Check if 'gene_id', 'disease', and 'expriment' query parameters are provided
    if ($request->has('gene_id') && $request->has('disease') && $request->has('expriment')) {
        $geneIds = $request->input('gene_id');
        $disease = $request->input('disease');
        $expriment = $request->input('expriment');
        
        // Use $geneIds, $disease, and $expriment to filter SRAs
        // You would typically query your database here
        $sras = GeneData::whereIn('gene_id', $geneIds)
            ->where('disease', $disease)
            ->where('expriment', $expriment)
            ->distinct()
            ->pluck('sra');
    } else {
        // If any of the parameters is missing, consider all SRAs
        // Query your database for all SRAs here
        $sras = GeneData::distinct()->pluck('sra');
    }

    return response()->json($sras);
}


public function uniqueDisease()
{
    $uniqueDiseases = GeneData::distinct()
        ->pluck('disease')
        ->toArray();

    return response()->json( $uniqueDiseases);
}

}