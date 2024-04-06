<?php

namespace App\Charts;

use App\Models\Doctor;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DoctorChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {   

        $poli_umum = Doctor::where('specialization','umum')->count();
        $poli_mata = Doctor::where('specialization','mata')->count();
        $poli_gigi = Doctor::where('specialization','gigi')->count();

        return $this->chart->donutChart()
            // ->setTitle('Top 3 scorers of the team.')
            // ->setSubtitle('Season 2021.')
            ->addData([$poli_umum, $poli_mata, $poli_gigi])
            ->setColors(['#FF455F', '#008FFB','#00E396'])
            ->setLabels(['Poli Umum', 'Poli Mata', 'Poli Gigi'])
            ->setFontFamily('Poppins', 'sans-serif');
    }
}
