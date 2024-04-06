<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class AdminDashboardDoctorChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $poli_umum = Doctor::where('spesialisasi','umum')->count();
        $poli_mata = Doctor::where('spesialisasi','mata')->count();
        $poli_gigi = Doctor::where('spesialisasi','gigi')->count();

        return $this->chart->donutChart()()
            // ->setTitle('Top 3 scorers of the team.')
            // ->setSubtitle('Season 2021.')
            ->addData([$poli_umum, $poli_mata, $poli_gigi])
            ->setColors(['#FF455F', '#008FFB','#00E396'])
            ->setLabels(['Poli Umum', 'Poli Mata', 'Poli Gigi'])
            ->setFontFamily('Poppins', 'sans-serif');
    }
    }
}
