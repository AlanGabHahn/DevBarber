<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;
use App\Models\BarberPhoto;
use App\Models\BarberService;
use App\Models\BarberTestimonial;

class BarberController extends Controller
{   

    private $loggedUser;

    /**
     * construct for BarberController
     */
    public function __construct() 
    {
        $this->middleware('auth:api');
        $this->loggedUser = Auth::user();
    }

    /**
     * Conexão com a api de geolocalização do Google
     * @param $address
     */
    private function searchGeo($address) 
    {
        $key = env('MAPS_KEY', null);
        $address = urlencode($address);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $array = ['error' => ''];
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $city = $request->input('city');
        $offset = $request->input('offset');
        if (!$offset) {
            $offset = 0;
        }
        if (!empty($city)) {
            $response = $this->searchGeo($city);
            if (count($response['results']) > 0) {
                $lat = $response['results'][0]['geometry']['location']['lat'];
                $lng = $response['results'][0]['geometry']['location']['lng'];
            }
        } elseif (!empty($lat) && !empty($lng)) {
            $response = $this->searchGeo($lat. ',' .$lng);
            if (count($response['results']) > 0) {
                $city = $response['results'][0]['formatted_address'];
            }
        } else {
            $lat = '';
            $lng = '';
            $city = 'Caxias do Sul';
        }
        $collection = Barber::select(Barber::raw('*, SQRT(
            POW(69.1 * (latitude - '.$lat.'), 2) +
            POW(69.1 * ('.$lng.' - longitude) * COS(latitude / 57.3), 2)
        ) AS distance'))
        ->havingRaw('distance < ?', [25])
        ->orderBy('distance', 'ASC')
        ->offset($offset)
        ->limit(10)
        ->get();
        foreach ($collection as $barber => $value) {
            $barber[$value]['avatar'] = url('media/avatars/'.$barber[$value]['avatar']);
        }
        $array['data'] = $collection;
        $array['location'] = 'Caxias do Sul';
        return $array;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $array = [
            'error' => ''
        ];
        $barber = Barber::find($id);
        if ($barber) {
            $barber['avatar'] = url('media/avatars/'.$barber['avatar']);
            $barber['favorited'] = false;
            $barber['photos'] = [];
            $barber['services'] = [];
            $barber['testimonials'] = [];
            $barber['available'] = [];
            $array['data'] = $barber;
            /** Buscando as fotos vinculadas ao barbeiro */
            $barber['photos'] = BarberPhoto::select(['id', 'image'])
                ->where('barber_id', $barber->id)
                ->get();
            foreach($barber['photos'] as $bpKey => $bpValue) {
                $barber['photos'][$bpValue]['image'] = url('media/uploads/'.$barber['photos'][$bpValue]['image']);
            }
            /** Buscando os serviço do barbeiro */
            $barber['services'] = BarberService::select(['id', 'name', 'price'])
                ->where('barber_id', $barber->id)
                ->get();
            /** Buscando os depoimentos*/
            $barber['testimonials'] = BarberTestimonial::select(['id', 'name', 'rate', 'body'])
                ->where('barber_id', $barber->id)
                ->get();
            $array['data'] = $barber;
        } else {
            $array['error'] = 'Barbeiro não encontrado';
        }
        return $array; 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
