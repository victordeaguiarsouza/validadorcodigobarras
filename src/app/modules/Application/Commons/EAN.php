<?php

/**
 * Responsável por rotinas de validação de codigo de barras
 * 
 * @author Victor Aguiar <victor@dnasistemas.com>
 * @copyright Copyright (c) 2017
 */

namespace Application\Commons;

class EAN {

    /**
     * Verifica se o EAN informado é válido
     *
     * @param  string $ean
     * @return boolean
     */
    public static function validar($ean) {
        
        try{

            $ean = (string) $ean;

            if (strlen($ean) < 8 || strlen($ean) > 18 ||
                (strlen($ean) != 8 && strlen($ean) != 12 &&
                strlen($ean) != 13 && strlen($ean) != 14 &&
                strlen($ean) != 18)) {
                return false;
            }

            $lastDigit = substr($ean,-1);
            $checkSum  = 0;
            
            if (!isset($lastDigit)) { return false; }

            $arr = str_split($ean);
            $arr = array_reverse($arr);
            
            //remove o primeiro elemento do array 
            //(nesse caso eh o digito verificador que foi jogado para a primeira posição)
            unset($arr[0]);

            $oddTotal  = 0;
            $evenTotal = 0;

            foreach ($arr as $key => $value) {
                if ( ($key+1)%2 == 0) { 
                    $oddTotal += $value * 3;
                } else { 
                    $evenTotal += $value; 
                }
            }
            
            $checkSum = (10 - (($evenTotal + $oddTotal) % 10)) % 10;    
            
        }catch (\Exception $e){
        
            throw $e;
        }

        return ($checkSum == $lastDigit);
    }

}