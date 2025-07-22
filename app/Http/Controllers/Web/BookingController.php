<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->middleware('auth');
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        // عرض كل الحجوزات للمستخدم الحالي (أو ممكن للمدير حسب التعديل)
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->orderBy('start_date')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        // لعرض فورم حجز غرفة (نحتاج الغرف المتاحة)
        $rooms = Room::where('status', 1)->get();
        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'guests_count' => 'required|integer|min:1',
            'payment_status' => 'required|boolean',
        ]);

        $result = $this->bookingService->create_booking($request->all(), $request->room_id);

        if ($result['code'] === 200) {
            return redirect()->route('bookings.index')->with('success', $result['message']);
        }

        return back()->withErrors($result['message'])->withInput();
    }

    public function show($id)
    {
        $booking = Booking::with('room', 'user')->findOrFail($id);

        // تحقق أن الحجز يخص المستخدم الحالي أو لديه صلاحية (يمكن إضافة ذلك حسب الحاجة)
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return redirect()->route('bookings.index')->with('error', 'Booking not found.');
        }

        if (Auth::id() !== $booking->user_id) {
            return redirect()->route('bookings.index')->with('error', 'You do not have permission to edit this booking.');
        }

        // افتراضياً، إذا تحتاج جلب بيانات المستخدمين والغرف لعرضها في form:
        $users = User::all();
        $rooms = Room::all();

        return view('bookings.edit', compact('booking', 'users', 'rooms'));
    }


    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return redirect()->route('bookings.index')->with('error', 'Booking not found.');
        }

        if (Auth::id() !== $booking->user_id) {
            return redirect()->route('bookings.index')->with('error', 'This booking does not belong to you.');
        }

        $daysDifference = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($booking->start_date), false);
        if ($daysDifference <= 1) {
            return redirect()->route('bookings.index')->with('error', 'You can no longer edit this booking. It must be updated at least 2 days before start date.');
        }

        // تحقق البيانات المطلوبة (يمكن استخدام FormRequest بدلاً من هذا الجزء)
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'guests_count' => 'required|integer|min:1',
        ]);

        $booking->update([
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'guests_count' => $validatedData['guests_count'],
        ]);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $result = $this->bookingService->delete_booking($id);

        if ($result['code'] === 200) {
            return redirect()->route('bookings.index')->with('success', $result['message']);
        }

        return back()->withErrors($result['message']);
    }
}
