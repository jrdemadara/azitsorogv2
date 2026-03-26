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
                ["name" => "Manila Science High School", "is_active" => true],
            );

            $schoolB = School::query()->updateOrCreate(
                ["code" => "XYZ"],
                ["name" => "Ramon Magsaysay High School", "is_active" => true],
            );

            $schoolC = School::query()->updateOrCreate(
                ["code" => "LMN"],
                ["name" => "Araullo High School", "is_active" => true],
            );

            // Allowed emails (all schools)
            $allowed = [
                ["owner_name" => "Johnny Demadara", "email" => "jrdemadara@protonmail.com"],
                ["owner_name" => "Azitsorog Inc Admin", "email" => "azitsoroginc@gmail.com"],
            ];

            foreach ([$schoolA, $schoolB, $schoolC] as $school) {
                foreach ($allowed as $entry) {
                    AllowedEmail::query()->updateOrCreate(
                        ["school_id" => $school->id, "email" => $entry["email"]],
                        ["owner_name" => $entry["owner_name"], "is_used" => false],
                    );
                }
            }

            // Students (3 per school; demonstrates same student_id_number across schools)
            $studentA1 = Student::query()->updateOrCreate(
                ["school_id" => $schoolA->id, "student_id_number" => "123"],
                ["full_name" => "Ethan Reyes", "is_active" => true],
            );

            $studentA2 = Student::query()->updateOrCreate(
                ["school_id" => $schoolA->id, "student_id_number" => "456"],
                ["full_name" => "Liam Santos", "is_active" => true],
            );

            $studentA3 = Student::query()->updateOrCreate(
                ["school_id" => $schoolA->id, "student_id_number" => "789"],
                ["full_name" => "Noah Garcia", "is_active" => true],
            );

            $studentB1 = Student::query()->updateOrCreate(
                ["school_id" => $schoolB->id, "student_id_number" => "123"],
                ["full_name" => "Ava Cruz", "is_active" => true],
            );

            $studentB2 = Student::query()->updateOrCreate(
                ["school_id" => $schoolB->id, "student_id_number" => "456"],
                ["full_name" => "Mia Flores", "is_active" => true],
            );

            $studentB3 = Student::query()->updateOrCreate(
                ["school_id" => $schoolB->id, "student_id_number" => "789"],
                ["full_name" => "Lucas Mendoza", "is_active" => true],
            );

            $studentC1 = Student::query()->updateOrCreate(
                ["school_id" => $schoolC->id, "student_id_number" => "123"],
                ["full_name" => "Sophia Torres", "is_active" => true],
            );

            $studentC2 = Student::query()->updateOrCreate(
                ["school_id" => $schoolC->id, "student_id_number" => "456"],
                ["full_name" => "Isabella Ramos", "is_active" => true],
            );

            $studentC3 = Student::query()->updateOrCreate(
                ["school_id" => $schoolC->id, "student_id_number" => "789"],
                ["full_name" => "Daniel Navarro", "is_active" => true],
            );

            // Map emails to students they are allowed to link
            $authorizations = [
                [$schoolA->id, $studentA1->id, "jrdemadara@protonmail.com"],
                [$schoolA->id, $studentA2->id, "azitsoroginc@gmail.com"],
                [$schoolA->id, $studentA3->id, "jrdemadara@protonmail.com"],
                [$schoolB->id, $studentB1->id, "jrdemadara@protonmail.com"],
                [$schoolB->id, $studentB2->id, "azitsoroginc@gmail.com"],
                [$schoolB->id, $studentB3->id, "jrdemadara@protonmail.com"],
                [$schoolC->id, $studentC1->id, "azitsoroginc@gmail.com"],
                [$schoolC->id, $studentC2->id, "jrdemadara@protonmail.com"],
                [$schoolC->id, $studentC3->id, "azitsoroginc@gmail.com"],
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
