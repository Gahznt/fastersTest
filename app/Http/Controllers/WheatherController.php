<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Climas;
use DateTime;
use phpDocumentor\Reflection\PseudoTypes\False_;

use function PHPUnit\Framework\isNull;

class WheatherController extends Controller
{
    public function wheather(request $request) {
        date_default_timezone_set('America/Sao_Paulo');
        $array = ['error' => ''];
        $rules = [ 'city' =>  'required'];
        $now = new DateTime("now");
        $validator = Validator::make($request->only('city'), $rules);
        
        if($validator->fails()) {
           $array['error'] = "Campo não pode ser vazio.";
           return $array['error'];
        }
        $city = $request->only('city');
        $bd = Climas::where('city', $city['city'])->first();

        if(empty($bd) == false) {
            $differenceInSeconds = WheatherController::dateCalculate($bd, $now);

            if($differenceInSeconds < 1200) {
                $new_clima = [
                    'city' => $bd->city,
                    'temp' => $bd->temp,
                    'insert_at' => $now
                ];
                return view ('retorno', [
                    'new_clima' => $new_clima
                ]);
            } else {
                $new_clima = WheatherController::callApi($city, $now);

                $bd->city = $new_clima['city'];
                $bd->temp = $new_clima['temp'];
                $bd->insert_at = $now;
                $bd->save();

                return view ('retorno', [
                    'new_clima' => $new_clima
                ]);
            }
        }else {
            $new_clima = WheatherController::callApi($city, $now);

            if($new_clima['cod'] == 200){
            Climas::create($new_clima);
            return view ('retorno', [
                'new_clima' => $new_clima
            ]);
            } else {
                return view ('retorno', [
                    'message' => "Cidade não encontrada."
                ]);
            }
        }
    }

    private static function callApi($city, $now) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_URL, 'api.openweathermap.org/data/2.5/weather?q='.$city['city'].'&appid=13236e0cee066e8bbf5275dae2cff701&units=metric');
        $results = curl_exec($ch);
        $decode = json_decode($results);

        if($decode->cod == 200) {
            return [
                'city' => $decode->name,
                'temp' => $decode->main->temp,
                'cod' => $decode->cod,
                'insert_at' => $now
            ];
        } else {
            return [
                'cod' => $decode->cod
            ];
        }


    }

    private static function dateCalculate($bd, $now) {
        $insert = new DateTime($bd->insert_at);
        $timeFirst  = strtotime($now->format('c'));
        $timeSecond = strtotime($insert->format('c'));
        return $timeFirst - $timeSecond;
    }

}
