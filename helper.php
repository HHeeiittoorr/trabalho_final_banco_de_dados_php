<?php
function traduz_data_para_exibir($data) {
    if($data == "" || $data == "0000-00-00") {
        return "00/00/0000";
    }
    
    return $data_formatada = date('d/m/Y', strtotime($data));
}

?>