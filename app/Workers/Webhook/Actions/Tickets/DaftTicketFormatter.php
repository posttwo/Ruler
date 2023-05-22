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
        $bathrooms = null;
        $link = null;
        $location = null;

        $dom = new Dom;
        $dom->load($body['html_body']);
        $a = $dom->find('img');

        //Find Main Image and Link
        foreach($a as $img){
            $src = $img->getAttribute('src');
            if(strpos($src, 'https://media.daft.ie/') === 0){
                $src = str_replace('= ', "", $src);
                $imageSrc = $src;
                $link = $img->getParent()->getAttribute('href');
            }
        }

        //Find Address
        $location = $dom->find('td .address > div > a')[0]->innerHtml;

        //Find Bed + Bath
        $parentInfoTable = $dom->find('td .address')[0]->getParent()->getParent()->find('tr');
        $interestingData = $parentInfoTable[4]->find('table > tr > td > table > tr');
        $bedrooms = $interestingData[0]->find('td')[0]->innerHtml;
        $bathrooms = $interestingData[0]->find('td')[1]->innerHtml;

        //Find Price
        $a = $invocation->body['subject'];
        $a = (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT);
        $price = abs($a);

        $title = "[€{$price}] - {$bedrooms} {$bathrooms} | {$location}";
        $body = "== {$location} \n\r";
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
