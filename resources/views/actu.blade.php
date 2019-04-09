<?php

// édition du début du fichier XML
$xml = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0">';
$xml .= '<channel>';
$xml .= '<title>Actualité de la FFF</title>';
$xml .= '<link>https://www.fff.fr/equipes-de-france/1/france-a/actualites</link>';
$xml .= '<description>Obtenez les dernières actualités sur l\'équipe de France</description>';

for ($i=0; $i<=$count-1; $i++){
    $xml .= '<item>';
    $xml .= '<title>'.$title[$i].'</title>';
    $xml .= '<link>'.$link[$i].'</link>';
    $xml .= '<image>';
    $xml .= ' <url>https://www.fff.fr/'.$t_img[$i].'</url>';
    $xml .= '</image>';
    $xml .= '</item>';
}


// édition de la fin du fichier XML
$xml .= '</channel>';
$xml .= '</rss>';

// écriture dans le fichier
$fp = fopen("flux.xml", 'w+');
fseek($fp, 0);
fputs($fp, $xml);
fclose($fp);


?>
