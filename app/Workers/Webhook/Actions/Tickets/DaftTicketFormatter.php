<?php

namespace App\Workers\Webhook\Actions\Tickets;
use Symfony\Component\DomCrawler\Crawler;
use PHPHtmlParser\Dom;

class DaftTicketFormatter {

    public function invoke($ticket, $invocation, $config){
        $body = $invocation->body;
        $head = $invocation->head;
        $plain = $body['plain_body'];
        
        //Ticket elements
        $imageSrc = null;
        $price = null;
        $bedrooms = null;
        $link = null;
        $location = null;

        $html = str_replace('3D"', '"', $body['html_body']);
        $html = str_replace('=3D=', '=', $html);
        $html = str_replace('=3D', '=', $html);
        $dom = new Dom;
        $dom->load($html);
        $a = $dom->find('img');

        //Find Main Image
        foreach($a as $img){
            $src = $img->getAttribute('src');
            if(strpos($src, 'https://photos.cdn.dsch.ie/') === 0){
                $src = str_replace('= ', "", $src);
                $imageSrc = $src;
            }
        }

        //Find Price
        $a = $dom->find('title')->text;
        $a = (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT);
        $price = substr($a, 3);

        //Find other details
        $a = explode("\n", $plain);
        $link = $a[2];
        $bedrooms = $a[7];
        $bedrooms = substr($bedrooms, 0, strpos($bedrooms, "Bath") + 4);
        $location = $a[6];


        $title = "[€{$price}] - {$bedrooms} | {$location}";
        $body = "== {$location} \n\r";
        $body .= "{image {$imageSrc}} \n\r";
        $body .= "**View: ** {$link} \n\r";
        $body .= "**Bedrooms: **{$bedrooms} \n\r";
        $body .= "**Price: ** {$price}";

        return 
        [
            'transactions' => [
                [
                    'type' => 'title',
                    'value' => $title
                ],
                [
                    'type' => 'description',
                    'value' => $body
                ]
            ]
            /*'root_field' => [
                'name' => 'objectIdentifier',
                'value' => 'T172'
            ]*/
        ];
    }
}