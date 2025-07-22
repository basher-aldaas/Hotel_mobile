<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Room;
use App\Services\Offer\OfferService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OfferController extends Controller
{
    protected OfferService $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    // عرض كل العروض
    public function index()
    {
        $offers = Offer::where('end_date', '>', Carbon::today())->paginate(10);

        return view('offers.index', [
            'offers' => $offers,
        ]);
    }


    public function create()
    {
        $rooms = Room::all(); // جلب كل الغرف لاستخدامها في قائمة الاختيار

        return view('offers.create', compact('rooms'));
    }

    // تخزين العرض الجديد
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $result = $this->offerService->create_offer($request->all(), $request->room_id);

        if ($result['code'] !== 200) {
            return redirect()->route('offers.index')->withErrors($result['message']);
        }

        return redirect()->route('offers.index')->with('success', $result['message']);
    }


    // صفحة تعديل عرض معين
    public function edit(Offer $offer)
    {
        $rooms = Room::all(); // أو يمكنك تصفيتها حسب الحاجة
        return view('offers.edit', compact('rooms' , 'offer'));
    }

    // تحديث العرض
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $result = $this->offerService->update_offer($request->all(), $offer->id);

        if ($result['code'] !== 200) {
            return redirect()->back()->withErrors($result['message']);
        }

        return redirect()->route('offers.index')->with('success', $result['message']);
    }

    // حذف عرض
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'offer deleted successfully.');

    }

    // عرض العروض المرتبطة بغرفة معينة
    public function showOffersByRoom(Room $room)
    {
        $result = $this->offerService->show_offers_room($room->id);

        return view('offers.by_room', [
            'room' => $room,
            'offers' => $result['data'] ?? [],
            'message' => $result['message'],
        ]);
    }

    public function show(Offer $offer)
    {
        return view('offers.show', compact('offer'));
    }

}
