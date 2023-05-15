<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteCollection;
use App\Models\Note;
use App\Http\Resources\Note as NoteResource;

class NoteController extends Controller
{
    public function index()
    {
        return new NoteCollection(Note::all());
    }

    public function show($id)
    {
        return new NoteResource(Note::findOrFail($id));
    }

    public function store(StoreNoteRequest $request)
    {
        $note = Note::create($request->all());

        return (new NoteResource($note))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateNoteRequest $request, $id)
    {
        $editedNote = Note::findOrFail($id);
        $editedNote->title = $request->title;
        $editedNote->content = $request->content;
        $editedNote->save();

        return (new NoteResource($editedNote))
            ->response()
            ->setStatusCode(200);
    }

    public function delete($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json(null, 204);
    }
}
