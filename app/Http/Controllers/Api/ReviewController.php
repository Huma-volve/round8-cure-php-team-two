<?php

namespace App\Http\Controllers\Api;
use app\Helper\apiResponse;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointmentDateTime = Carbon::parse($appointment['appointment_date'] . ' ' . $appointment['appointment_time']);

        if (!$appointmentDateTime->isPast()) {
            return apiResponse(400, "The Appointment is still upcoming.");
        }

        $existingReview = Review::where('appointment_id', $request->appointment_id)->first();
        if ($existingReview) {
            return apiResponse(400, "A review for this appointment already exists.");

        }
        $review = Review::create([
            'appointment_id' => $request->appointment_id,
            'doctor_id' => $request->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => 2
        ]);

        return apiResponse(201, "Review added successfully.", $review);

    }

    public function update(Request $request, $id)
    {

        $review = Review::findOrFail($id);

        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]);


        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointmentDateTime = Carbon::parse($appointment['appointment_date'] . ' ' . $appointment['appointment_time']);


        if (!$appointmentDateTime->isPast()) {
            return apiResponse(400, "The Appointment is still upcoming.");
        }


    
        $review->update([
            'appointment_id' => $request->appointment_id,
            'doctor_id' => $request->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => 2
        ]);

        return apiResponse(200, "Review updated successfully.", $review);
    }

    public function get_review($id)
    {
        $review = Review::with('doctor', 'user')->find($id);

        if (!$review) {
            return apiResponse(404, 'Review not found', );
        }

        return apiResponse($review, 'Review retrieved successfully');
    }
    public function destroy_review($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return apiResponse(404, "Review not found");

        }

        $review->delete();


        return apiResponse(
            200,
            'Review deleted successfully'
        );
    }
    public function get_reviews_to_doctor($doctor_id)
    {
        $reviews = Review::with('user')
            ->where('doctor_id', $doctor_id)
            ->get();

        if ($reviews->isEmpty()) {

            return apiResponse(404, 'No reviews found for this doctor');
        }

        return apiResponse(200, 'Reviews retrieved successfully', $reviews);

    }


}
