<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CardContents;

class CardContentsController extends Controller
{
    //
    public function create() {
        return view('card_contents.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'card_no' => 'unique:card_contents,card_no|required|max:20',
            'name' => 'required|max:20',
            'category' => 'required|max:20',
            'hp' => 'nullable|integer|max:500',
            'weakness' => 'max:20',
            'resistance' => 'max:20',
            'escape_energy' => 'nullable|integer|max:10',
            'effect' => 'max:200',
        ]);

        $validated['user_id'] = auth()->id();


        $card_contents = CardContents::create($validated);

       
        $request->session()->flash('message', '保存しました');
        return back();
    }

    public function index() {
        $cared_contents = CardContents::all();
        $card_contents = orderBy('card_no')->paginate(10);
        return view('card_contents.index', compact('card_contents'));
    }

    public function show($card_contents_id) {
        $card_content = CardContents::where('card_contents_id', $card_contents_id)->first();
        return view('card_contents.show', compact('card_content'));
    }

    public function edit(CardContents $card_content) {
        return view('card_contents.edit', compact('card_content'));
    }

    public function update(Request $request, CardContents $card_content) {
        $validated = $request->validate([
            'card_no' => 'required|max:20',
            'name' => 'required|max:20',
            'category' => 'required|max:20',
            'hp' => 'nullable|integer|max:500',
            'weakness' => 'max:20',
            'resistance' => 'max:20',
            'escape_energy' => 'nullable|integer|max:10',
            'effect' => 'max:200',
        ]);

        $validated['user_id'] = auth()->id();

        $card_content->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }

    public function destroy(Request $request, CardContents $card_content) {
        $card_content->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('card_contents.index');
    }
}
