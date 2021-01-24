<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\School;
use App\ClassModel;
use App\Attendance;
use App\Ticket;
use App\EnterAndLeave;
use App\Student;

class HomeController extends Controller
{
    protected $access_token;
    protected $channel_secret;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // :point_down: アクセストークン
        $this->access_token = env('LINE_ACCESS_TOKEN');
        // :point_down: チャンネルシークレット
        $this->channel_secret = env('LINE_CHANNEL_SECRET');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getSchoolsByCategoryId($categoryId)
    {
        $schools = School::where('category_id', $categoryId)->get();
        return response()->json($schools);
    }

    public function getClassesBySchoolId($categoryId, $schoolId)
    {
        $classes = ClassModel::where('school_id', $schoolId)->get();
        return response()->json($classes);
    }

    public function showAttendanceForm($categoryId, $schoolId, $classId)
    {
        $date = date("Y/m/d");
        $category_id = $categoryId;
        $school_id = $schoolId;
        $class_id = $classId;

        $attendance = Attendance::where('event_date', $date)
            ->where('category_id', $category_id)
            ->where('school_id', $school_id)
            ->where('class_id', $class_id)
            ->get()
            ->first();

        if ($attendance === null)
        {
            $attendance = new Attendance();
            $attendance->event_date = $date;
            $attendance->company_id = Auth::user()->id;
            $attendance->category_id = $category_id;
            $attendance->school_id = $school_id;
            $attendance->class_id = $class_id;
            $attendance->save();

            $tickets = Ticket::where('class_id', $class_id)->get();
            foreach($tickets as $ticket)
            {
                $enter_and_leave = new EnterAndLeave();
                $enter_and_leave->attendance_id = $attendance->id;
                $enter_and_leave->student_id = $ticket->student_id;
                $enter_and_leave->save();
            }
        }

        return view('attendance',[
            'attendance' => $attendance,
        ]);
    }

    public function enter($attendanceId, $enterAndLeaveId)
    {
        $enter_and_leave = EnterAndLeave::where('id', $enterAndLeaveId)->get()->first();
        $student = Student::where('id', $enter_and_leave->student_id)->get()->first();

        // 入退室のLINE通知先を取得
        $notification_line_ids = $student->notification_line_ids;
        if (count($notification_line_ids) > 0)
        {
            // 生徒を取得
            $attendance = Attendance::where('id', $attendanceId)->get()->first();

            // LINE通知先送信するメッセージの作成
            $message = $attendance->category->name;
            $message = $message. ' ';
            $message = $message . $attendance->school->name;
            $message = $message. ' (';
            $message = $message . substr($attendance->class->time_from, 0, strlen($attendance->class->time_from) - 3);
            $message = $message. ' ～ ';
            $message = $message . substr($attendance->class->time_to, 0, strlen($attendance->class->time_to) - 3);
            $message = $message . ') に ';
            $message = $message . $student->name;
            $message = $message . ' さんが入室しました。';

            $http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->access_token);
            $bot         = new \LINE\LINEBot($http_client, ['channelSecret' => $this->channel_secret]);
            foreach($notification_line_ids as $notification_line_id)
            {
                // メッセージをLINE通知
                $line_user_id = $notification_line_id->line_id;
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $response    = $bot->pushMessage($line_user_id, $textMessageBuilder);
            }
        }

        // 入室情報を更新
        $enter_and_leave->enter = date('H:i:s');
        $enter_and_leave->save();

        return response('');
    }

    public function leave($attendanceId, $enterAndLeaveId)
    {
        $enter_and_leave = EnterAndLeave::where('id', $enterAndLeaveId)->get()->first();
        $student = Student::where('id', $enter_and_leave->student_id)->get()->first();


        // 入退室のLINE通知先を取得
        $notification_line_ids = $student->notification_line_ids;
        if (count($notification_line_ids) > 0)
        {
            // 生徒を取得
            $attendance = Attendance::where('id', $attendanceId)->get()->first();

            // LINE通知先送信するメッセージの作成
            $message = $attendance->category->name;
            $message = $message. ' ';
            $message = $message . $attendance->school->name;
            $message = $message. ' (';
            $message = $message . substr($attendance->class->time_from, 0, strlen($attendance->class->time_from) - 3);
            $message = $message. ' ～ ';
            $message = $message . substr($attendance->class->time_to, 0, strlen($attendance->class->time_to) - 3);
            $message = $message . ') に ';
            $message = $message . $student->name;
            $message = $message . ' さんが退室しました。';

            $http_client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->access_token);
            $bot         = new \LINE\LINEBot($http_client, ['channelSecret' => $this->channel_secret]);
            foreach($notification_line_ids as $notification_line_id)
            {
                // メッセージをLINE通知
                $line_user_id = $notification_line_id->line_id;
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $response    = $bot->pushMessage($line_user_id, $textMessageBuilder);
            }
        }

        // 入室情報を更新
        $enter_and_leave->leave = date('H:i:s');
        $enter_and_leave->save();

        return response('');
    }
}
