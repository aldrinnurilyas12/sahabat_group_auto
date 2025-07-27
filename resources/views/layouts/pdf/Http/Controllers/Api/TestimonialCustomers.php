<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TestimonialModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialCustomers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TestimonialModel::create([
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'testimonial' => $request->testimonial,
            'rating' => $request->rating,
            'criticsm_and_suggestion' => $request->criticsm_and_suggestion,
            'hidden_name' => $request->hidden_name
        ]);

        session()->flash('message_success', 'Testimonial anda berhasil dikirim');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function all_testimonial_show(): View
    {

        $all_testimonial = TestimonialModel::all();
        $avg_rating = TestimonialModel::avg('rating');
        $rating_total = TestimonialModel::count('id');
        return view('layouts.landing_page.main_page.all_testimonial', compact('all_testimonial', 'avg_rating', 'rating_total'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
