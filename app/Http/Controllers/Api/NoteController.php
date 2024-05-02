<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $notes = Note::where('user_id', $request->user()->id)->orderBy('id', 'desc')->get();
        return response()->json(['notes' => $notes], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'note' => 'required',
        ]);

        $note = new Note();
        $note->user_id = $request->user()->id;
        $note->title = $request->title;
        $note->note = $request->note;
        $note->save();

        return response()->json(['message' => 'Note created successfully'] , 201);
    }
}
