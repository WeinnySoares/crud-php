<?php

namespace App\Http\Controllers;

use App\Articles;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class ArticlesController extends Controller
{
    public function insert(Request $request){

        $search = $this->limpar_string($request['search']);
        $uri = (empty($search))?'https://www.questmultimarcas.com.br/estoque':'https://www.questmultimarcas.com.br/estoque?termo='.$search;

        $response = Curl::to($uri)->get();
        $regex = '/<article class=\"card clearfix\" (.*?)<\/article>/s';

        preg_match_all($regex,$response,$results);

       $response = $results;
       $arr = [];

       foreach($results as $result){
           foreach($result as $key => $value){
               $clear = filter_var($value, FILTER_SANITIZE_STRING);
               $clear = str_replace(["\r","\r\n","\n"],"",$clear);
               $clear = preg_replace(array("/id=(.*?)>/s","/&(.*?);/s"),"",$clear);

               $json = '{"nome":"'.$clear;
               $json = str_replace("Ano:", '","ano":"', $json);
               $json = str_replace("Quilometragem:", '","quilometragem":"', $json);
               $json = str_replace("Combustível:", '","combustivel":"', $json);
               $json = str_replace("Câmbio:", '","cambio":"', $json);
               $json = str_replace("Portas:", '","portas":"', $json);
               $json = str_replace("Cor:", '","cor":"', $json);
               $json = str_replace("PREÇO:", '","preco":"', $json);
               $json = $json.'"}';

               $car = utf8_encode($json);
               $car = json_decode($car);
               array_push($arr,$car);
           }
       }

        foreach($arr as $car){
            $article = new Articles;
            $article->img_hef = 'img';
            $article->name = trim($car->nome);
            $article->description = 'desc';
            $article->year = trim($car->ano);
            $article->fuel = trim($car->combustivel);
            $article->ports = trim($car->portas);
            $article->color = trim($car->cor);
            $article->exchange = trim($car->cambio);
            $article->mileage = trim($car->quilometragem);
            $article->price = trim($car->preco);
            $article->save();
        }

        return 'success';
    }

    public function all(){
        return Articles::all();
    }

    public function index(){
        return view('captura');
    }

    public function remove($id){
        //DB::table('articles')->where('id','='$id)->delete();
    }

    private function limpar_string($string) {
        if($string !== mb_convert_encoding(mb_convert_encoding($string, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
            $string = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string));
        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $string);
        $string = html_entity_decode($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), ' ', $string);
        $string = preg_replace('/( ){2,}/', '$1', $string);
        $string = strtolower(trim($string));
        return $string;
    }
}
