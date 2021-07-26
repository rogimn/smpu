<?php
    // Função que valida o CPF
    $cpf = str_pad(ereg_replace('[^0-9]', '', $_POST['cpf']), 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            echo"false";
        }
        else {
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
 
                $d = ((10 * $d) % 11) % 10;
 
                    if ($cpf{$c} != $d) {
                        echo"false";
                    }
            }

            echo"true";
        }
?>