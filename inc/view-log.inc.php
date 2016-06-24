<?php
$log = file_get_contents(PATH_LOG);
$out = explode('|', $log);
$i = 0;

foreach ($out as $value) {
    if ((int)$value){
     echo   date('d-m-Y H:i:s', $value) . ' - ';
    }else{
        $location = explode('/', $value);

        for ($i = 1; $i < count($location); $i++){
            if($i % 2 > 0){
                echo "http://$location[$i] -> ";
            }else{
              echo "/".$location[$i] . ' ';
            }
            }
        echo '<br>';
    }

}
?>