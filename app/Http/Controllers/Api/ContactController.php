<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $contact = ContactMessage::create($request->validated());

        return apiResponse(
            true,
            'Message sent successfully',
            $contact,
            201
        );
    }
}
