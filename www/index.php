<?php

$filename = 'base';
if (file_exists($filename)) {
    header('Location: /cargaCorretagem/index.php'); 
} else {
    $filename = '/var/www/install_base_formdin.sh';
    if (file_exists($filename)) {
        echo "<h2>Baixando e instalado o FormDin FrameWork PHP</h2>";
        echo "<br>Essa etapa pode demorar um pouco";
        //$output = shell_exec($filename);
        //echo "<pre>".var_dump($output)."</pre>";
        /*
        $return_var = null;
        exec ( $filename , $output , $return_var );        
        echo "<pre>".var_dump($output)."</pre>";
        echo "<pre>".var_dump($return_var)."</pre>";
        */
    } else {
        echo "Falha na construção da imagem docker";
    }
}

?>