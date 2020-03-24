<?php

use GuzzleHttp\Client as Client;
use PHPHtmlParser\Dom as Dom;

class CrawlData
{
    private $successCallback;
    private $errorCallback;
    private $try = 0;
    private $dom;
    private $data;

    public function run()
    {
        try {
            $this->request();
            $this->extract();
            call_user_func($this->successCallback, $this->data);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }
    private function request()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://www.covidmaroc.ma');
        $this->dom = (string) $response->getBody();
    }
    private function extract()
    {
        $dom = new Dom;
        $dom = $dom->loadStr($this->dom);
        $mainRow = $dom->find("table tbody tr", 1);
        $tableDivision = (new Dom)->loadStr((string) $mainRow)->find("td");

        // Last Update
        $lastUpdate = $dom->find("table tbody tr td p font")->text();

        $first_td = (new Dom)->loadStr((string) $tableDivision[0])->find("p");
        // Recovered Cases
        $recovered = (new Dom)->loadStr((string) $first_td[0])->find("font", 0)->text();

        // Death Cases
        $deaths = (new Dom)->loadStr((string) $first_td[0])->find("font", 1)->text();

        // Detected Cases
        $cases = (new Dom)->loadStr((string) $tableDivision[1])->find("p")->text();

        // Clean Cases
        $clean = (new Dom)->loadStr((string) $tableDivision[2])->find("p")->text();

        $this->data = [
            'last_update' => html_entity_decode(preg_replace("/^\D+|\D+$/", "", $lastUpdate)),
            'cases' => (int) $cases,
            'deaths' => (int) $deaths,
            'clean' => (int) $clean,
            'recovered' => (int) $recovered,
            'active' => (int) $cases - (int) $deaths - (int) $recovered
        ];
    }
    private function handleError($error)
    {
        if ($this->try < 3) {
            $this->try++;
            sleep(3);
            $this->run();
        } else call_user_func($this->errorCallback, $error);
    }
    public function onError($callback)
    {
        $this->errorCallback = $callback;
    }
    public function onSuccess($callback)
    {
        $this->successCallback = $callback;
    }
}
