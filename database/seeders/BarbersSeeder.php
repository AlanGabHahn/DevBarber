<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barber;
use App\Models\BarberPhoto;
use App\Models\BarberService;
use App\Models\BarberTestimonial;
use App\Models\BarberAvailability;

class BarbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0;$i<15;$i++) {
            $names = [
                "Sofia",
                "Lucas",
                "Isabella",
                "Pedro",
                "Emma",
                "Miguel",
                "Olivia",
                "Leonardo",
                "Alan",
                "Matheus"
            ];
            $lastNames = [
                "Silva",
                "Santos",
                "Pereira",
                "Ferreira",
                "Costa",
                "Rodrigues",
                "Martins",
                "Gomes",
                "Alves",
                "Ribeiro"
            ];
            $services = [
                "Corte de cabelo",
                "Barba completa",
                "Corte e barba",
                "Design de sobrancelhas",
                "Tratamento capilar",
                "Depilação facial",
                "Coloração de cabelo",
                "Penteado",
                "Massagem capilar",
                "Tratamento de barba"
            ];
            $depoiments = [
                "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
                "When an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.",
                "Many desktop publishing packages and web page editors now use Lorem Ipsum",
                "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
            ];
            $ns = rand(3, 6);
            $barber = new Barber();
            $barber->name = $names[rand(0, count($names)-1)].' '.$lastNames[rand(0, count($lastNames)-1)];
            $barber->avatar = rand(1, 4).'.png';
            $barber->stars = rand(2, 4).'.'.rand(0, 9);
            $barber->latitude = '-23.5'.rand(0, 9).'30907';
            $barber->longitude = '-46.6'.rand(0, 9).'82795';
            $barber->save();

            for ($i=0;$i<0;$i++) {
                $barberPhoto = new BarberPhoto();
                $barberPhoto->barber_id = $barber->id;
                $barberPhoto->image = rand(2, 4).'.png';
                $barberPhoto->save();
            }

            for ($w=0;$w<$ns;$w++) {
                $barberService = new BarberService();
                $barberService->barber_id = $barber->id;
                $barberService->name = $services[rand(0, count($services)-1)];
                $barberService->price = rand(1, 99).'.'.rand(0, 100);
                $barberService->save();
            }

            for ($w=0;$w<3;$w++) {
                $barberTestimonials = new BarberTestimonial();
                $barberTestimonials->barber_id = $barber->id;
                $barberTestimonials->name = $names[rand(0, count($names)-1)].' '.$lastNames[rand(0, count($lastNames)-1)];
                $barberTestimonials->rate = rand(2, 4).'.'.rand(0, 9);
                $barberTestimonials->body = $depoiments[rand(0, count($depoiments)-1)];
                $barberTestimonials->save();
            }

            for ($e=0;$e<4;$e++) {
                $rAdd = rand(7, 10);
                $hours = [];
                for ($r=0;$r<8;$r++) {
                    $time = $r + $rAdd;
                    if ($time < 10) {
                        $time = '0'.$time;
                    }
                    $hours = $time.":00";
                }
                $babaerAvailability = new BarberAvailability();
                $babaerAvailability->barber_id = $barber->id; 
                $babaerAvailability->weekday = $e;
                $babaerAvailability->hours =  $hours; 
                $babaerAvailability->save();
            }
        }
    }
}
