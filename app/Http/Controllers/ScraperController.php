<?php

namespace App\Http\Controllers;

use Goutte\Client;

class ScraperController extends Controller
{

    function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            if($invert == FALSE) {
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            }
            else {
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
            }
        }
        elseif($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    public function index(){

        $client = new Client();
        $crawler = $client->request('GET', 'https://www.fff.fr/equipes-de-france/1/france-a/actualites');
        $title = $crawler->filter('.title')->each(function ($node) {

           $a = self::strip_tags_content($node->html());

           return trim($a);

        });

        $link = $crawler->filter('.dib')->each(function ($node) {

           $a = $node->link()->getUri();

            return $a;

        });

        $img = $crawler->filter('.post img')->each(function ($node) {

            $a = $node->attr('src');

            $b = str_replace(array("small_diapo", "diapo_small"), array("large_article", "diapo_slideshow_fullsize"), $a);

            return $b;

        });

        $img2 = $crawler->filter('.poste_push img')->each(function ($node) {

            $a = $node->attr('src');

            $b = str_replace(array("small_diapo", "diapo_small"), array("large_article", "diapo_slideshow_fullsize"), $a);

            return $b;

        });

        $t_img = array_merge($img, $img2);

        $count = count($title);

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
            $xml .= '<description> <![CDATA[ <img src="https://www.fff.fr/'.$t_img[$i].'"/>]]></description>';
            $xml .= '</item>';
        }


        // édition de la fin du fichier XML
        $xml .= '</channel>';
        $xml .= '</rss>';


        return response($xml)->header('Content-Type', 'text/xml');


    }



}
