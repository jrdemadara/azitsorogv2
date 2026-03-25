<?php

namespace App\Http\Controllers\GateLog;

use App\Models\Gatelog\GateLog;
use App\Models\Gatelog\NotificationDelivery;
use App\Models\Gatelog\ParentDevice;
use App\Models\Gatelog\ParentStudent;
use App\Models\Gatelog\School;
use App\Models\Gatelog\Student;
use App\Models\Gatelog\StudentEmailAuthorization;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GateLogController extends \App\Http\Controllers\Controller
{
    public function schools()
    {
        $schools = School::query()
            ->where("is_active", true)
            ->orderBy("name")
            ->get(["code", "name"]);

        return response()->json([
            "data" => $schools,
        ]);
    }

    public function linkStudent(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            "school_code" => ["required", "string"],
            "student_id_number" => ["required", "string"],
        ]);

        $school = School::query()->where("code", $data["school_code"])->first();
        if (!$school) {
            return response()->json(["message" => "Invalid school context."], 422);
        }

        $student = Student::query()
            ->where("school_id", $school->id)
            ->where("student_id_number", $data["student_id_number"])
            ->where("is_active", true)
            ->first();

        if (!$student) {
            return response()->json(["message" => "Student not found."], 404);
        }

        $isAuthorized = StudentEmailAuthorization::query()
            ->where("school_id", $school->id)
            ->where("student_id", $student->id)
            ->whereRaw("LOWER(email) = ?", [strtolower($user->email)])
            ->exists();

        if (!$isAuthorized) {
            return response()->json(["message" => "Student ID is not tied to your email."], 403);
        }

        ParentStudent::query()->firstOrCreate([
            "school_id" => $school->id,
            "user_id" => $user->id,
            "student_id" => $student->id,
        ]);

        return response()->json(["message" => "Student linked successfully."]);
    }

    public function registerDevice(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            "platform" => ["nullable", "string", "max:20"],
            "push_token" => ["required", "string"],
        ]);

        ParentDevice::query()->updateOrCreate(
            [
                "school_id" => $user->school_id,
                "user_id" => $user->id,
                "push_token" => $data["push_token"],
            ],
            [
                "platform" => $data["platform"] ?? null,
                "is_active" => true,
                "last_seen_at" => Carbon::now(),
            ],
        );

        return response()->json(["message" => "Device registered."]);
    }

    public function linkedStudents(Request $request)
    {
        $user = $request->user();

        $rows = ParentStudent::query()
            ->join("students", function ($join) {
                $join->on("students.id", "=", "parent_students.student_id");
                $join->on("students.school_id", "=", "parent_students.school_id");
            })
            ->join("schools", "schools.id", "=", "parent_students.school_id")
            ->where("parent_students.user_id", $user->id)
            ->orderByDesc("parent_students.id")
            ->get([
                "students.student_id_number",
                "students.full_name",
                "schools.code as school_code",
                "schools.name as school_name",
            ]);

        return response()->json([
            "data" => $rows,
        ]);
    }

    public function ingestGateLog(Request $request)
    {
        $apiKey = (string) env("GATELOG_INGEST_KEY", "");
        $provided = (string) $request->header("X-GateLog-Key", "");
        if ($apiKey === "" || !hash_equals($apiKey, $provided)) {
            return response()->json(["message" => "Unauthorized."], 401);
        }

        $data = $request->validate([
            "school_code" => ["required", "string"],
            "student_id_number" => ["required", "string"],
            "direction" => ["required", "in:in,out"],
            "logged_at" => ["required", "date"],
            "gate_name" => ["nullable", "string", "max:255"],
            "source_ref" => ["nullable", "string", "max:255"],
        ]);

        $school = School::query()->where("code", $data["school_code"])->first();
        if (!$school) {
            return response()->json(["message" => "School not found."], 422);
        }

        $student = Student::query()
            ->where("school_id", $school->id)
            ->where("student_id_number", $data["student_id_number"])
            ->first();

        if (!$student) {
            return response()->json(["message" => "Student not found."], 404);
        }

        $sourceRef = $data["source_ref"] ?? null;
        if ($sourceRef) {
            $log = GateLog::query()->firstOrCreate(
                [
                    "school_id" => $school->id,
                    "source_ref" => $sourceRef,
                ],
                [
                    "student_id" => $student->id,
                    "direction" => $data["direction"],
                    "logged_at" => Carbon::parse($data["logged_at"]),
                    "gate_name" => $data["gate_name"] ?? null,
                ],
            );
        } else {
            $log = GateLog::query()->create([
                "school_id" => $school->id,
                "student_id" => $student->id,
                "direction" => $data["direction"],
                "logged_at" => Carbon::parse($data["logged_at"]),
                "gate_name" => $data["gate_name"] ?? null,
                "source_ref" => null,
            ]);
        }

        if ($log->wasRecentlyCreated) {
            $parentLinks = ParentStudent::query()
                ->where("school_id", $school->id)
                ->where("student_id", $student->id)
                ->get(["user_id"]);

            foreach ($parentLinks as $link) {
                NotificationDelivery::query()->create([
                    "school_id" => $school->id,
                    "gate_log_id" => $log->id,
                    "user_id" => $link->user_id,
                    "status" => "pending",
                ]);
            }
        }

        return response()->json(["message" => "Gate log ingested.", "id" => $log->id], 201);
    }

    public function pullLogs(Request $request)
    {
        $user = $request->user();
        $since = $request->query("since");

        $studentIds = ParentStudent::query()->where("user_id", $user->id)->pluck("student_id");

        $query = GateLog::query()
            ->whereIn("student_id", $studentIds)
            ->orderByDesc("logged_at")
            ->limit(100);

        if ($since) {
            $query->where("logged_at", ">", Carbon::parse($since));
        }

        return response()->json($query->get());
    }
}
