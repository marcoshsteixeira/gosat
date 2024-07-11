<?php

namespace App\Http\Controllers;

use App\Models\Cpf;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class SimulationController extends Controller
{
    public function credit(Request $request) {
        $cpfValue = $request->input('cpf');

        $cpf = \App\Models\Cpf::where('cpf', $cpfValue)->first();

        try {
            $cpf = Cpf::where('cpf', $cpfValue)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'CPF não encontrado'], 404);
        }

        return \App\Models\Institutions::whereHas('loans', function($query) use ($cpf) {
            $query->where('cpf_id', $cpf->id);
        })->with(['modalities' => function($query) use ($cpf) {
            $query->whereHas('loans', function($query) use ($cpf) {
                $query->where('cpf_id', $cpf->id);
            });
        }])->get();
    }

    public function offer(Request $request) {
        $cpfValue = $request->input('cpf');
        $institutionId = $request->input('institution');
        $modalitiesHash = $request->input('modality');

        return \App\Models\Modalities::whereHas('institutions', function ($query) use ($cpfValue) {
            $query->whereHas('loans', function ($query) use ($cpfValue) {
                $query->where('cpf_id', function ($query) use ($cpfValue) {
                    $query->select('id')
                        ->from('cpfs')
                        ->where('cpf', $cpfValue);
                });
            });
        })->where('code', $modalitiesHash)
          ->where('institutions_id', $institutionId)
          ->get();

    }

    public function betterOptions() {
        $offers = \App\Models\Modalities::select('modalities.*')
        ->orderBy('fess')
        ->orderBy('minValue')
        ->orderByDesc('maxValue')
        ->orderBy('minPortion')
        ->orderByDesc('maxPortion')
        ->limit(3)
        ->get();

        $better = array();
        foreach($offers as $key => $offer) {
            $better[$key] = array(
                'institution' => $offer->institutions->name,
                'modality' => $offer->name,
                'payValue' => round(1000 * pow((1 + ($offer->fess /100)), $offer->minPortion), 2),
                'value' => 1000,
                'fess' => $offer->fess  . '%',
                'portion' => $offer->minPortion,
            );
        }


        return $better;
    }
}
