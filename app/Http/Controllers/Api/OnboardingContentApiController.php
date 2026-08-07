<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnboardingContent;
use App\Models\Language;
use Stichoza\GoogleTranslate\GoogleTranslate;

class OnboardingContentApiController extends Controller
{
    // ✅ Store Onboarding Content
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title1' => 'required|string',
    //         'title2' => 'required|string',
    //         'language_id' => 'required|exists:languages,id',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    //     ]);

    //     $imageName = null;

    //     if($request->hasFile('image')){
    //         $imageName = time().'.'.$request->image->extension();
    //         $request->image->move(public_path('uploads/onboarding'), $imageName);
    //     }

    //     $content = OnboardingContent::create([
    //         'title1' => $request->title1,
    //         'title2' => $request->title2,
    //         'language_id' => $request->language_id,
    //         'image' => $imageName
    //     ]);

    //     // ✅ Convert relative path to full URL in response
    //     $content->image = $imageName ? url('uploads/onboarding/'.$imageName) : null;

    //     // ✅ Translate success message according to language_id
    //     $language = Language::find($request->language_id);
    //     $tr = new GoogleTranslate($language->lang_code ?? 'en');

    //     return response()->json([
    //         'status' => true,
    //         'message' => $tr->translate('Onboarding content added successfully'),
    //         'data' => $content
    //     ], 200);
    // }

public function store(Request $request)
{
    $request->validate([
        'title1' => 'required|string',
        'title2' => 'required|string',
        'language_id' => 'required|exists:languages,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $imageName = null;
    if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/onboarding'), $imageName);
    }

    // ✅ Convert real newline to literal \n for DB
    $saveTitle1 = str_replace("\n", "\\n", $request->title1);
    $saveTitle2 = str_replace("\n", "\\n", $request->title2);

    $content = OnboardingContent::create([
        'title1' => $saveTitle1,
        'title2' => $saveTitle2,
        'language_id' => $request->language_id,
        'image' => $imageName
    ]);

    // ✅ Response me \n remove and show in single line
    $responseTitle1 = str_replace(["\\n", "\n"], " ", $saveTitle1);
    $responseTitle2 = str_replace(["\\n", "\n"], " ", $saveTitle2);

    // ✅ Full image URL
    $content->image = $imageName ? url('uploads/onboarding/'.$imageName) : null;
    $content->title1 = $responseTitle1;
    $content->title2 = $responseTitle2;

    return response()->json([
        'status' => true,
        'message' => "Onboarding content added successfully",
        'data' => $content
    ]);
}

    // ✅ Get onboarding content by language
public function get(Request $request)
{
    $languageId = $request->input('language_id', 1);

    // ✅ Validate language
    $language = Language::find($languageId);
    if (!$language) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid language selected'
        ], 400);
    }

    // ✅ Get content in requested language
    $contents = OnboardingContent::where('language_id', $languageId)->get();

    // ✅ Fallback to English if empty
    if ($contents->isEmpty()) {
        $contents = OnboardingContent::where('language_id', 1)->get(); 
        $languageId = 1;
    }

    // ✅ Add full image URL
    $contents->map(function ($item) {
        $item->image = $item->image ? url('uploads/onboarding/'.$item->image) : null;
        return $item;
    });

    // ✅ Auto translate message
    $tr = new \Stichoza\GoogleTranslate\GoogleTranslate($language->lang_code);

    return response()->json([
        'status' => true,
        'message' => $tr->translate('Onboarding content fetched successfully'),
        'data' => $contents
    ], 200);
}

}
