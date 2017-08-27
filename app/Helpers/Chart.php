<?php
namespace App\Helpers;

use App\Helpers\Contracts\ChartContract;
use Carbon\Carbon;
use Mexitek\PHPColors\Color;

class Chart implements ChartContract
{
    /**
     * Start and end dates
     *
     * @var Carbon
     */
    private $start_date;
    private $end_date;

    /**
     * Dataset collection
     *
     * @var Collection
     */
    private $dataset;

    /**
     * Init
     *
     * @param Carbon $start_date
     * @param Carbon $end_date
     */
    public function init($start_date, $end_date)
    {
        $this->dataset = collect();
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * Return the current dataset
     *
     * @return Collection
     */
    public function getDataSet()
    {
        return $this->dataset;
    }

    /**
     * Set line and bar dataset
     *
     * @param Collection $data
     * @param String $title
     * @param Integer $i
     */
    public function setLineBarDataSet($data, $title, $i = 0)
    {
        // Copy the Carbon instance of start_date
        $iterate_date = $this->start_date->copy();
        $color = new Color(config('chartjs.colors.' . $i));
        $collection = collect();
        // Set dates with leads
        while ($iterate_date <= $this->end_date) {
            $count = isset($data[$iterate_date->toDateString()]) ? $data[$iterate_date->toDateString()] : 0;
            $collection->push($count);
            $iterate_date->addDay();
        }
        $this->dataset = collect([
            'label' => $title,
            'data' => $collection,
            'fillColor' => '#' . $color->getHex(),
            'strokeColor' => '#' . $color->getHex(),
            'pointColor' => '#' . $color->getHex(),
            'pointHighlightStroke' => '#' . $color->getHex()
        ]);
    }

    /**
     * Create JSON data for Line and Bar chart
     *
     * @param  Collection $dataset
     * @return JSON
     */
    public function getLineBarChart($dataset = null)
    {
        // If user is passing a custom dataset, set it
        if ($dataset) {
            return collect([
                'labels' => $this->setLabel(),
                'datasets' => $dataset
            ])->toJson();
        } else {
            return collect([
                'labels' => $this->setLabel(),
                'datasets' => [$this->dataset]
            ])->toJson();
        }
    }

    /**
     * Set and get pie chart
     *
     * @param  Collection $data
     * @return Collection
     */
    public function getPieChart($data)
    {
        foreach ($data as $key => $value) {
            $i = 0;
            $dataset[$key] = collect();
            foreach ($data->get($key) as $k => $v) {
                $color = new Color(config('chartjs.colors.' . $i));
                $dataset[$key]->push([
                    'value' => $v,
                    'color' => '#' . $color->lighten(20),
                    'highlight' => '#' . $color->lighten(25),
                    'label' => $k
                ]);
                $i++;
            }
        }
        return $dataset;
    }

    /**
     * Set label for line and bar charts
     *
     * @return Collection
     */
    private function setLabel()
    {
        // Copy the Carbon instance of start_date
        $iterate_date = $this->start_date->copy();
        $labels = collect();
        while ($iterate_date <= $this->end_date) {
            $labels->push($iterate_date->format('M d'));
            $iterate_date->addDay();
        }
        return $labels;
    }
}