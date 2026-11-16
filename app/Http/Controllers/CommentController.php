<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
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

    public function isNegativeComment($text)
    {
        $text = Str::lower($text);
        $negativeKeywords = [
            'badword1',
            'scam',
            'fake',
            'trash',
            'worst',
            'hate',
            'not',
            'မကောင်းဘူး',
            'လိမ်တယ်',
            'အတု',
            'မလှဘူး',
            'မကြိုက်ဘူး'
        ];

        foreach ($negativeKeywords as $word) {
            if (str_contains($text, strtolower($word))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $isNegative = $this->isNegativeComment($request->comment);

        Comment::create([
            'user_id'     => Auth::id(),
            'product_id'  => $product_id,
            'comment'     => $request->comment,
            'is_approved' => $isNegative ? 0 : 1,
        ]);

        return back()->with('success', 'Comment submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $isNegative = $this->isNegativeComment($request->comment);

        $comment->update([
            'comment'     => $request->comment,
            'is_approved' => $isNegative ? 0 : 1,
        ]);

        return back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        if (Auth::id() !== $comment->user_id && optional($user)->role !== 'admin') {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
