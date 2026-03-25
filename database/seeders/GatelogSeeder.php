<?php

namespace Database\Seeders;

use App\Models\Gatelog\AllowedEmail;
use App\Models\Gatelog\School;
use App\Models\Gatelog\Student;
use App\Models\Gatelog\StudentEmailAuthorization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GatelogSeeder extends Seeder
{
    public function run(): void
    {
        DB::connection("pgsql_gatelog")->transaction(function () {
            // Schools
            $schoolA = School::query()->updateOrCreate(
                ["code" => "ABC"],
                ["name" => "ABC International School", "is_active" => true],
            );

            $schoolB = School::query()->updateOrCreate(
                ["code" => "XYZ"],
                ["name" => "XYZ Science High", "is_active" => true],
            );

            // Allowed emails (ABC school)
            $allowed = [
                ["owner_name" => "Johnny Demadara", "email" => "jrdemadara@protonmail.com"],
                ["owner_name" => "Azitsorog Inc Admin", "email" => "azitsoroginc@gmail.com"],
                ["owner_name" => "Azitsorog Inc Support", "email" => "azitsoroginc@yahoo.com"],
            ];

            foreach ($allowed as $entry) {
                AllowedEmail::query()->updateOrCreate(
                    ["school_id" => $schoolA->id, "email" => $entry["email"]],
                    ["owner_name" => $entry["owner_name"], "is_used" => false],
                );
            }

            // Students (demonstrate same ID number in different schools)
            $studentA1 = Student::query()->updateOrCreate(
                ["school_id" => $schoolA->id, "student_id_number" => "123"],
                ["full_name" => "Student A One", "is_active" => true],
            );

            $studentB1 = Student::query()->updateOrCreate(
                ["school_id" => $schoolB->id, "student_id_number" => "123"],
                ["full_name" => "Student B One", "is_active" => true],
            );

            $studentA2 = Student::query()->updateOrCreate(
                ["school_id" => $schoolA->id, "student_id_number" => "456"],
                ["full_name" => "Student A Two", "is_active" => true],
            );

            // Map emails to students they are allowed to link
            $authorizations = [
                [$schoolA->id, $studentA1->id, "jrdemadara@protonmail.com"],
                [$schoolA->id, $studentA2->id, "azitsoroginc@gmail.com"],
                [$schoolB->id, $studentB1->id, "azitsoroginc@yahoo.com"],
            ];

            foreach ($authorizations as [$schoolId, $studentId, $email]) {
                StudentEmailAuthorization::query()->firstOrCreate([
                    "school_id" => $schoolId,
                    "student_id" => $studentId,
                    "email" => $email,
                ]);
            }
        });
    }
}
