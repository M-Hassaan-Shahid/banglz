<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSetting;

class AppointmentsSeeder extends Seeder
{
    public function run()
    {
        // Check if appointments page setting already exists
        $existing = PageSetting::where('page_type', 'appointments')->first();
        
        if ($existing) {
            echo "Appointments page setting already exists. Skipping...\n";
            return;
        }

        PageSetting::create([
            'page_type' => 'appointments',
            'page_name' => 'appointments',
            'heading' => 'Book Your Personal Appointment',
            'description' => 'Book your personal appointment for styling and personalized consultation',
            'meta_data' => [
                'appointments' => [
                    [
                        'title' => 'CUSTOM BANGLE SET',
                        'description' => 'Create your perfect bangle set with our expert guidance and personalized styling.',
                        'image' => 'ear.jpg',
                        'link' => '/appointment'
                    ],
                    [
                        'title' => 'In-person Appointment',
                        'description' => 'Visit our store for a personalized consultation and styling session.',
                        'image' => 'ear.jpg',
                        'link' => '/appointment'
                    ],
                    [
                        'title' => 'CURATED JEWELRY LOOK',
                        'description' => 'Get a complete jewelry look curated by our professional stylists.',
                        'image' => 'ear.jpg',
                        'link' => '/appointment'
                    ],
                    [
                        'title' => 'CUSTOM DESIGN',
                        'description' => 'Design your own unique jewelry piece with our custom design service.',
                        'image' => 'ear.jpg',
                        'link' => '/appointment'
                    ]
                ]
            ]
        ]);

        echo "✅ Appointments page setting created successfully!\n";
    }
}
