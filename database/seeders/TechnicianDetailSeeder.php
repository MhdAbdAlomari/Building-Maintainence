<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\TechnicianDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $serviceIds = Service::pluck('id');//الخدمات الموجودة ليختار منها عشوائيا IDSيسحب ال  

        
        User::where('role', 'technician')->get()->each(function ($tech) use ($serviceIds) {
            TechnicianDetail::updateOrCreate(// مرة ثانية seederلضمان عدم تكرار السجل لو شغلنا ال  firstOrCreate استخدمنا 
                ['user_id' => $tech->id],
                ['service_id' => $serviceIds->random(), 'years_of_experience' => 3]//عشوائي ID ينشئ  service لل  IDهنا اذا لم يجد 
            );
        });
    }
}
