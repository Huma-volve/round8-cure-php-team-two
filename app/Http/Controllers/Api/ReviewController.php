<?php

namespace App\Http\Controllers\Api;
use app\Helpers\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Appointment;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Ramsey\Collection\Collection;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointmentDateTime = Carbon::parse($appointment['appointment_date'] . ' ' . $appointment['appointment_time']);
        if ($appointment->user_id != Auth()->id()) {
            return apiResponse(400, "You are not authorized to view this appointment.");
        }

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
            'user_id' => Auth()->id()
        ]);

        return apiResponse(201, "Review added successfully.", new ReviewResource($review));

    }

    public function update(UpdateReviewRequest $request, $id)
    {


        $review = Review::findOrFail($id);


        $review->fill($request->validated());
        $review->save();
        if ($review->user_id != Auth()->id()) {
            return apiResponse(400, "You are not authorized to Edite this review");
        }

        return apiResponse(200, "Review updated successfully.", new ReviewResource($review));
    }

    public function get_review($id)
    {
        $review = Review::with('doctor', 'user')->find($id);

        if (!$review) {
            return apiResponse(404, 'Review not found', );
        }

        return apiResponse(200, 'Review retrieved successfully', new ReviewResource($review));
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
            ->paginate(10); 


        if ($reviews->isEmpty()) {

            return apiResponse(404, 'No reviews found for this doctor');
        }

        return apiResponse(200, 'Reviews retrieved successfully', ReviewResource::Collection($reviews));

    }


}
