<?php
namespace App\Validation;

class CustomRules 
{

    public function alpha_name(string $str) 
    {
        // Verificar que la cadena (campo validado) sea un nombre(s) o apellido(s) válido
        if (preg_match('/^[a-zA-Zá-üÁ-Ü ]*$/', $str)) {
            return true;
        }

        return false;
    }

}