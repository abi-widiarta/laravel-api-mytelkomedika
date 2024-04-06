<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $doctorsData = [
            [
                "name" => "Dr. Budi Santoso",
                "email"=> "budi@gmail.com",
                "username" => "budi_santoso",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123126",
                "phone" => "081237010266",
                "gender" => "L",
                "birthdate" => "1985-05-15",
                "address" => "Jl. Cipto Mangunkusumo",
                "image" => "/uploads/img/budi_santoso.png",
            ],
            [
                "name" => "Dr. Dian Permata",
                "email"=> "dian@gmail.com",
                "username" => "dian_permata",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123127",
                "phone" => "081237010277",
                "gender" => "L",
                "birthdate" => "1982-08-20",
                "address" => "Jl. Diponegoro",
                "image" => "/uploads/img/dian_permata.png",
            ],
            [
                "name" => "Dr. Eka Wijaya",
                "email"=> "eka@gmail.com",
                "username" => "eka_wijaya",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123128",
                "phone" => "081237010288",
                "gender" => "P",
                "birthdate" => "1980-03-10",
                "address" => "Jl. Kusuma Negara",
                "image" => "/uploads/img/eka_wijaya.png",
            ],
            // ... (tambahkan 7 data lainnya)
            [
                "name" => "Dr. Fika Maulana",
                "email"=> "fika@gmail.com",
                "username" => "fika_maulana",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123136",
                "phone" => "081237010366",
                "gender" => "P",
                "birthdate" => "1987-11-25",
                "address" => "Jl. Merdeka",
                "image" => "/uploads/img/fika_maulana.png",
            ],
            [
                "name" => "Dr. Gita Pratama",
                "email"=> "gita@gmail.com",
                "username" => "gita_pratama",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123137",
                "phone" => "081237010377",
                "gender" => "L",
                "birthdate" => "1983-09-18",
                "address" => "Jl. Hasanuddin",
                "image" => "/uploads/img/gita_pratama.png",
            ],
            [
                "name" => "Dr. Hana Susanti",
                "email"=> "hana@gmail.com",
                "username" => "hana_susanti",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123138",
                "phone" => "081237010388",
                "gender" => "P",
                "birthdate" => "1984-04-05",
                "address" => "Jl. Pahlawan",
                "image" => "/uploads/img/hana_susanti.png",
            ],
            [
                "name" => "Dr. Irfan Widodo",
                "email"=> "irfan@gmail.com",
                "username" => "irfan_widodo",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "mata",
                "status" => "1",
                "registration_number" => "123139",
                "phone" => "081237010399",
                "gender" => "L",
                "birthdate" => "1981-06-30",
                "address" => "Jl. Sudirman",
                "image" => "/uploads/img/irfan_widodo.png",
            ],
            [
                "name" => "Dr. Joko Santoso",
                "email"=> "joko@gmail.com",
                "username" => "joko_santoso",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "mata",
                "status" => "1",
                "registration_number" => "123140",
                "phone" => "081237010400",
                "gender" => "L",
                "birthdate" => "1986-12-15",
                "address" => "Jl. Tambak Boyo",
                "image" => "/uploads/img/joko_santoso.png",
            ],
            [
                "name" => "Dr. Kiki Nurul",
                "email"=> "kiki@gmail.com",
                "username" => "kiki_nurul",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "mata",
                "status" => "1",
                "registration_number" => "123141",
                "phone" => "081237010411",
                "gender" => "P",
                "birthdate" => "1988-03-20",
                "address" => "Jl. Pemuda",
                "image" => "/uploads/img/kiki_nurul.png",
            ],
            [
                "name" => "Dr. Lina Anggraeni",
                "email"=> "lina@gmail.com",
                "username" => "lina_anggraeni",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "mata",
                "status" => "1",
                "registration_number" => "123142",
                "phone" => "081237010422",
                "gender" => "P",
                "birthdate" => "1989-08-10",
                "address" => "Jl. Kartini",
                "image" => "/uploads/img/lina_anggraeni.png",
            ],
            [
                "name" => "Dr. Mira Susanti",
                "email"=> "mira@gmail.com",
                "username" => "mira_susanti",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "mata",
                "status" => "1",
                "registration_number" => "123143",
                "phone" => "081237010433",
                "gender" => "P",
                "birthdate" => "1990-02-25",
                "address" => "Jl. Veteran",
                "image" => "/uploads/img/mira_susanti.png",
            ],
            [
                "name" => "Dr. Nanda Putra",
                "email"=> "nanda@gmail.com",
                "username" => "nanda_putra",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "mata",
                "status" => "1",
                "registration_number" => "123144",
                "phone" => "081237010444",
                "gender" => "L",
                "birthdate" => "1991-07-10",
                "address" => "Jl. Kalimantan",
                "image" => "/uploads/img/nanda_putra.png",
            ],
            [
                "name" => "Dr. Oki Rahayu",
                "email"=> "oki@gmail.com",
                "username" => "oki_rahayu",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123145",
                "phone" => "081237010455",
                "gender" => "P",
                "birthdate" => "1992-12-05",
                "address" => "Jl. Dipati Ukur",
                "image" => "/uploads/img/oki_rahayu.png",
            ],
            [
                "name" => "Dr. Purnama Setiawan",
                "email"=> "purnama@gmail.com",
                "username" => "purnama_setiawan",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123146",
                "phone" => "081237010466",
                "gender" => "L",
                "birthdate" => "1993-05-20",
                "address" => "Jl. Hayam Wuruk",
                "image" => "/uploads/img/purnama_setiawan.png",
            ],
            [
                "name" => "Dr. Qori Anwar",
                "email"=> "qori@gmail.com",
                "username" => "qori_anwar",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123147",
                "phone" => "081237010477",
                "gender" => "L",
                "birthdate" => "1994-10-15",
                "address" => "Jl. Pahlawan Revolusi",
                "image" => "/uploads/img/qori_anwar.png",
            ],
            [
                "name" => "Dr. Rini Kusuma",
                "email"=> "rini@gmail.com",
                "username" => "rini_kusuma",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123148",
                "phone" => "081237010488",
                "gender" => "P",
                "birthdate" => "1995-03-30",
                "address" => "Jl. Gatot Subroto",
                "image" => "/uploads/img/rini_kusuma.png",
            ],
            [
                "name" => "Dr. Satria Wibowo",
                "email"=> "satria@gmail.com",
                "username" => "satria_wibowo",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123149",
                "phone" => "081237010499",
                "gender" => "L",
                "birthdate" => "1996-08-25",
                "address" => "Jl. Sudirman",
                "image" => "/uploads/img/satria_wibowo.png",
            ],
            [
                "name" => "Dr. Tiara Putri",
                "email"=> "tiara@gmail.com",
                "username" => "tiara_putri",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123150",
                "phone" => "081237010500",
                "gender" => "P",
                "birthdate" => "1997-01-10",
                "address" => "Jl. Jakarta",
                "image" => "/uploads/img/tiara_putri.png",
            ],
            [
                "name" => "Dr. Umar Abdullah",
                "email"=> "umar@gmail.com",
                "username" => "umar_abdullah",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "gigi",
                "status" => "1",
                "registration_number" => "123151",
                "phone" => "081237010511",
                "gender" => "L",
                "birthdate" => "1998-06-15",
                "address" => "Jl. Diponegoro",
                "image" => "/uploads/img/umar_abdullah.png",
            ],
            [
                "name" => "Dr. Vina Rosita",
                "email"=> "vina@gmail.com",
                "username" => "vina_rosita",
                "password" => bcrypt("AAAAa1!"),
                "specialization" => "umum",
                "status" => "1",
                "registration_number" => "123152",
                "phone" => "081237010522",
                "gender" => "P",
                "birthdate" => "1999-11-20",
                "address" => "Jl. Pajajaran",
                "image" => "/uploads/img/vina_rosita.png",
            ],
        ];

        
        foreach ($doctorsData as $data) {
            Doctor::create([
                "name" => $data["name"],
                "email" => $data["email"],
                "username" => $data["username"],
                "password" => $data["password"],
                "specialization" => $data["specialization"],
                "status" => $data["status"],
                "registration_number" => $data["registration_number"],
                "phone" => $data["phone"],
                "gender" => $data["gender"],
                "birthdate" => $data["birthdate"],
                "address" => $data["address"],
                "image" => $data["image"],
            ]);
        }
    }
}