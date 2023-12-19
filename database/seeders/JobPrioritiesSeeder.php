<?php

namespace Database\Seeders;

use App\Enums\PriorityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobPriorities;

class JobPrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $message = array(
            array('priority_name' => 'Non Urgent','priority_desc' => 'Normal Priority within the next 4-10 business days.', 'sort_order' => 1, 'color' => '35C759', 'type' => PriorityType::NORMAL, 'term' => null),
            array('priority_name' => 'Medium','priority_desc' => 'Medium  Priority  within  the  next  48-72  hours.', 'sort_order' => 2, 'color' => '808080', 'type' => PriorityType::NORMAL, 'term' => null),
            array('priority_name' => 'High','priority_desc' => 'High Priority within the next 24-48 hours', 'sort_order' => 3, 'color' => 'FFCC02', 'type' => PriorityType::NORMAL, 'term' => null),
            array('priority_name' => 'After Hours Call Out','priority_desc' => 'After Hours Call Out Priority within the next 12 hours.', 'sort_order' => 4, 'color' => 'FF0C0E', 'type' => PriorityType::CRITICAL, 'term' => 'Our usual business hours 8:00 AM - 04:30 PM if we are unable to attend during this time a callout fee of $250 will be applicable, do you accept this charge?'),
        );
        foreach ($message as $key => $value) {
            JobPriorities::create([
                'priority_name' => $value['priority_name'],
                'priority_desc' => $value['priority_desc'],
                'sort_order' => $value['sort_order'],
                'color' => $value['color'],
                'type' => $value['type'],
                'term' => $value['term'],
            ]);
        }
    }
}
