<?php

$filename = 'base';
if (file_exists($filename)) {
    header('Location: /cargaCorretagem/index.php'); 
} else {
    header('Content-Type: text/html; charset=utf-8');
    $filename = '/var/www/install_base_formdin.sh';
    if (!file_exists($filename)) {
        echo "Falha na construção da imagem docker";
    } else {
        if(empty($_POST)){
            echo "<h2>A Instalação não está completa !! Mas estamos quase lá :-) </h2>";
            echo "<br>";
            echo "<br>Essa etapa pode demorar um pouco. Será preciso baixar e instalar o FormDin FrameWork PHP";
            echo "<br>";
            echo '<form name="form" method="post">'; 
            echo '<button name="baixar" value="baixar" type="submit">Continuar a instalação</button>';
            echo '</form>';
        }else{
            //$output = shell_exec($filename);
            //echo "<pre>".var_dump($output)."</pre>";
            $return_var = null;
            exec ( $filename , $output , $return_var );        
            echo "<pre>".var_dump($output)."</pre>";
            echo "<pre>".var_dump($return_var)."</pre>";
            echo '<form name="form" method="post">'; 
            echo '<button type="submit">Recarregar</button>';
            echo '</form>';            
        }
    }
}

?>