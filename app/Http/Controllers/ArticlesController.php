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
       $cont = 0;

       foreach($results as $result){
           foreach($result as $key => $value){
               $clear = filter_var($value, FILTER_SANITIZE_STRING);
               $clear = utf8_encode($clear);
               $clear = str_replace(array("\r","\r\n","\n",'/id=(.*?)>/s'),"",$clear);
               //$clear = json_encode($clear);
                array_push($arr,$clear);

           }
       }




        return $arr;

//// Variable to check
//$str = "<h1>Hello World!</h1>";
//// Remove HTML tags from string
//$newstr = filter_var($str, FILTER_SANITIZE_STRING);
//echo $newstr;
//
//        foreach([] as $car){
//            $articles = new Articles;
//            $article->img_hef = ;
//            $article->name = ;
//            $article->description = ;
//            $article->year = ;
//            $article->fuel = ;
//            $article->ports = ;
//            $article->color = ;
//            $article->exchange = ;
//            $article->mileage = ;
//            $article->save();
//        }
//
//        //return '';
    }

    public function all(){
        return view('captura');
    }
    public function remove($id){}

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
