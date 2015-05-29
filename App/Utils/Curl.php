<?php
namespace App\Utils;

class Curl {
    
    public function coletarHTML($url){
        try{
            $ch = curl_init();
            $timeout = 0;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $conteudo = curl_exec ($ch);
            curl_close($ch);

            //preg_match_all('(Example)', $conteudo, $conteudo2);
            //$conteudo2 = str_replace('Example', '<div class="alert alert-success" role="alert">Example</div>', strip_tags($conteudo));

            //echo '<pre>';
            //var_dump($conteudo2);
            //echo '</pre>';

            return $conteudo;
        }catch(Exception $e){
            error_log("Erro {$e->getMessage()} \n", 3, __DIR__."../errors.log");
            
        }
        
    }
    
}
