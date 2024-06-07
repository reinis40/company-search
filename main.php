<?php

require 'vendor/autoload.php';
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

findCompany(readline("Enter the company name : "));
function findCompany($company)
{
    if (empty($company))
    {
        exit("invalid input");
    }
    $url = 'https://data.gov.lv/dati/lv/api/3/action/datastore_search';
    $parameters = [
          'resource_id' => '25e80bf3-f107-4ab4-89ef-251b5b9374e9',
          'q' => $company
    ];
    $urlRequest = $url . '?' . http_build_query($parameters);
    $response = json_decode(file_get_contents($urlRequest));
    $showData = new ConsoleOutput();

    $dataTable = new Table($showData);
    $dataTable->setHeaders(['id', 'company name']);

    foreach ($response->result->records as $data)
    {
        $dataTable->addRow([
              $data->_id,
              $data->name
        ]);
    }
    $dataTable->render();
}
