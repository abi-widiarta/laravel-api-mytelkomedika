<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rand = [24, 20, 28, 19, 27, 23, 22, 29, 21, 25, 30, 26, 18, 20, 29, 27, 19, 23];
        $initial_report_id =1;

        for ($i=1; $i <= 18 ; $i++) { 
            for ($j = 1; $j <= $rand[$i - 1] ; $j++) {
                Review::create([
                    'doctor_id' => $i,
                    'report_id' => $initial_report_id,
                    'comment' => 'Dokternya sangat ramah, dan juga informatif',
                    'rating' => rand(4, 5),
                ]);
    
                Doctor::find($i)->update(
                    [
                        'rating' => number_format(Review::where('doctor_id', $i)->avg('rating'), 1),
                        'patient_total' => Reservation::where('doctor_id', $i)->where('status', 'completed')->count(),
                        'review_total' => Review::where('doctor_id', $i)->count()
                    ]
                );

                $initial_report_id = $initial_report_id + 1;
            }
        }

        // for ($i = 11; $i <= 20; $i++) {
        //     Review::create([
        //         'doctor_id' => 2,
        //         'report_id' => $i,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => rand(3, 5),
        //     ]);

        //     Doctor::find(2)->update(
        //         [
        //             'rating' => number_format(Review::where('doctor_id', 2)->avg('rating'), 1),
        //             'total_pasien' => Reservation::where('doctor_id', 2)->where('status', 'completed')->count(),
        //             'total_review' => Review::where('doctor_id', 2)->count()
        //         ]
        //     );
        // }

        // for ($i = 21; $i <= 30; $i++) {
        //     Review::create([
        //         'doctor_id' => 3,
        //         'report_id' => $i,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => rand(3, 5),
        //     ]);

        //     Doctor::find(3)->update(
        //         [
        //             'rating' => number_format(Review::where('doctor_id', 3)->avg('rating'), 1),
        //             'total_pasien' => Reservation::where('doctor_id', 3)->where('status', 'completed')->count(),
        //             'total_review' => Review::where('doctor_id', 3)->count()
        //         ]
        //     );
        // }

        // for ($i = 31; $i <= 40; $i++) {
        //     Review::create([
        //         'doctor_id' => 4,
        //         'report_id' => $i,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => rand(3, 5),
        //     ]);

        //     Doctor::find(4)->update(
        //         [
        //             'rating' => number_format(Review::where('doctor_id', 4)->avg('rating'), 1),
        //             'total_pasien' => Reservation::where('doctor_id', 4)->where('status', 'completed')->count(),
        //             'total_review' => Review::where('doctor_id', 4)->count()
        //         ]
        //     );
        // }

        // for ($i = 41; $i <= 50; $i++) {
        //     Review::create([
        //         'doctor_id' => 5,
        //         'report_id' => $i,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => rand(3, 5),
        //     ]);

        //     Doctor::find(5)->update(
        //         [
        //             'rating' => number_format(Review::where('doctor_id', 5)->avg('rating'), 1),
        //             'total_pasien' => Reservation::where('doctor_id', 5)->where('status', 'completed')->count(),
        //             'total_review' => Review::where('doctor_id', 5)->count()
        //         ]
        //     );
        // }

        // $reviewsDataDokter2 = [
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 11,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 12,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 13,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 14,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 15,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 16,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 17,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 18,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 19,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'report_id' => 20,
        //         'comment' => 'Dokternya sangat ramah, dan juga informatif',
        //         'rating' => random_int(3, 5),
        //     ],
        // ];

        // foreach ($reviewsDataDokter2 as $data) {
        //     Review::create([
        //         'doctor_id' => $data['doctor_id'],
        //         'report_id' => $data['report_id'],
        //         'comment' => $data['comment'],
        //         'rating' => $data['rating'],
        //     ]);

        //     Doctor::find($data['doctor_id'])->update(
        //         [
        //             'rating' => number_format(Review::where('doctor_id', $data['doctor_id'])->avg('rating'),1),
        //             'total_pasien' => Reservation::where('doctor_id',$data['doctor_id'])->where('status','completed')->count(),
        //             'total_review' => Review::where('doctor_id',$data['doctor_id'])->count()
        //         ]
        //     );
        // }
    }
}
