<?php

namespace App\Helpers;

use Tavo\ValidadorEc;

class Helpers
{

    public function validateString($string, $n)
    {
        $withOutLineBreaks = $this->deleteLineBreaks($string);
        $withoutTags = $this->withoutTags($withOutLineBreaks);
        $stringWithouEmoji = $this->deleteEmojiFromString($withoutTags);
        return $this->getFirstNCharacters($stringWithouEmoji, $n);
    }

    public function deleteLineBreaks($string)
    {
        $withOutLineBreaks = str_replace("\n", "", $string);
        return $withOutLineBreaks;
    }

    public function withoutTags($string)
    {
        $withoutTags = strip_tags($string);
        return $withoutTags;
    }

    public function deleteEmojiFromString($string)
    {
        $stringWithoutEmoji = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u', '', $string);
        return $stringWithoutEmoji;
    }

    public function getFirstNCharacters($string, $n)
    {
        $first_300_characters = substr($string, 0, $n);
        return $first_300_characters;
    }

    public function validarIdentification($type, $identification)
    {
        $validador = new ValidadorEc();
        switch ($type) {
            case 'CEDULA':
                if ($validador->validarCedula($identification))
                    return true;
                else
                    return false;

                break;

            case 'RUC':
                if ($validador->validarRucPersonaNatural($identification))
                    return true;
                else if ($validador->validarRucSociedadPrivada($identification))
                    return true;
                else if ($validador->validarRucSociedadPublica($identification))
                    return true;
                else
                    return false;
                break;
        }
    }

    public function validarCI($strCedula)
    {
        //aqui explico la logica de la validacion de una cedula de ecuador
        //El decimo Digito es un resultante de un calculo
        //Se trabaja con los 9 digitos de la cedula
        //Cada digito de posicion impar se lo duplica, si este es mayor que 9 se resta 9
        //Se suman todos los resultados de posicion impar
        //Ahora se suman todos los digitos de posicion par
        //se suman los dos resultados
        //se resta de la decena inmediata superior
        //este es el decimo digito
        //si la suma nos resulta 10, el decimo digito es cero

        if (is_null($strCedula) || empty($strCedula)) { //compruebo si que el numero enviado es vacio o null
            return "Por Favor Ingrese la Cedula";
        } else { //caso contrario sigo el proceso
            if (is_numeric($strCedula)) {
                $total_caracteres = strlen($strCedula); // se suma el total de caracteres
                if ($total_caracteres == 10) { //compruebo que tenga 10 digitos la cedula
                    $nro_region = substr($strCedula, 0, 2); //extraigo los dos primeros caracteres de izq a der
                    if ($nro_region >= 1 && $nro_region <= 24) { // compruebo a que region pertenece esta cedula//
                        $ult_digito = substr($strCedula, -1, 1); //extraigo el ultimo digito de la cedula
                        //extraigo los valores pares//
                        $valor2 = substr($strCedula, 1, 1);
                        $valor4 = substr($strCedula, 3, 1);
                        $valor6 = substr($strCedula, 5, 1);
                        $valor8 = substr($strCedula, 7, 1);
                        $suma_pares = ($valor2 + $valor4 + $valor6 + $valor8);
                        //extraigo los valores impares//
                        $valor1 = substr($strCedula, 0, 1);
                        $valor1 = ($valor1 * 2);
                        if ($valor1 > 9) {
                            $valor1 = ($valor1 - 9);
                        } else {
                        }
                        $valor3 = substr($strCedula, 2, 1);
                        $valor3 = ($valor3 * 2);
                        if ($valor3 > 9) {
                            $valor3 = ($valor3 - 9);
                        } else {
                        }
                        $valor5 = substr($strCedula, 4, 1);
                        $valor5 = ($valor5 * 2);
                        if ($valor5 > 9) {
                            $valor5 = ($valor5 - 9);
                        } else {
                        }
                        $valor7 = substr($strCedula, 6, 1);
                        $valor7 = ($valor7 * 2);
                        if ($valor7 > 9) {
                            $valor7 = ($valor7 - 9);
                        } else {
                        }
                        $valor9 = substr($strCedula, 8, 1);
                        $valor9 = ($valor9 * 2);
                        if ($valor9 > 9) {
                            $valor9 = ($valor9 - 9);
                        } else {
                        }

                        $suma_impares = ($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
                        $suma = ($suma_pares + $suma_impares);
                        $dis = substr($suma, 0, 1); //extraigo el primer numero de la suma
                        $dis = (($dis + 1) * 10); //luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
                        $digito = ($dis - $suma);
                        if ($digito == 10) {
                            $digito = '0';
                        } else {
                        } //si la suma nos resulta 10, el decimo digito es cero
                        if ($digito == $ult_digito) { //comparo los digitos final y ultimo
                            return "Cedula Correcta";
                        } else {
                            return "Cedula Incorrecta";
                        }
                    } else {
                        return "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
                    }
                } else {
                    return "Es un Numero y tiene solo" . $total_caracteres;
                }
            } else {
                return "Esta Cedula no corresponde a un Nro de Cedula de Ecuador";
            }
        }



        // $accion = $_GET["accion"];
        // $cedula =$this->validarCI($_GET["cedula"]);


        // if ($accion == "Validar") {

        //     return $cedula;
        // } else {

        //     return "no hay nada";
        // }
    }
}
