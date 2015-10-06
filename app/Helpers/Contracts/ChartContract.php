<?php

namespace App\Helpers\Contracts;

Interface ChartContract
{
    
    public function init($start_date, $end_date);

    public function getDataSet();

    public function setLineBarDataSet($data, $title, $i = 0);
    public function getLineBarChart();

    public function getPieChart($data);

}