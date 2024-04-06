<?php

namespace App\Charts;

use App\Models\Doctor;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ReviewChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $ratingPoliUmum = number_format(Doctor::where('specialization','umum')->get()->avg('rating'), 1);
        $ratingPoliMata = number_format(Doctor::where('specialization','mata')->get()->avg('rating'), 1);
        $ratingPoliGigi= number_format(Doctor::where('specialization','gigi')->get()->avg('rating'), 1);
        

        return $this->chart->barChart()
            ->addData('Poli Umum', [$ratingPoliUmum,0,0])
            ->addData('Poli Mata', [0,$ratingPoliMata,0])
            ->addData('Poli Gigi', [0,0,$ratingPoliGigi])
            ->setColors(['#FF455F', '#008FFB','#00E396'])
            ->setHeight(300)
            ->setXAxis(['Poli Umum', 'Poli Mata', 'Poli Gigi']);
    }
}
