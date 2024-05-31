<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlashcardController extends Controller
{
    public function practice(Request $request) {

        # Get unique subjects
        $subjects = Flashcard::distinct()->orderBy('subject')->pluck('subject');

        $selectedSubject = $request->query('subject', $subjects[0]);
        $flashcards = Flashcard::where('subject', $selectedSubject)->inRandomOrder()->get();
        return view('/flashcards/practice', ['flashcards' => $flashcards, 'subjects' => $subjects, 'selectedSubject' =>$selectedSubject ]);
    }


    public function upload(Request $request) {
        $request->validate([
            'flashcard_data' => 'required|file|mimes:csv',
            'subject' => 'required',
        ]);

        // Insert into database
        $csv_data = array_map('str_getcsv', file($request->file('flashcard_data')));
        $subject = $request['subject'];
        
        $formattedData = [];
        foreach ($csv_data as $row) {
            $formattedData[] = ['subject' => $subject, 'question'=> $row[0], 'answer' => $row[1]];
        }

        Flashcard::where('subject', $subject)->delete();
        Flashcard::insert($formattedData);

        return redirect('/flashcards/practice')->with('success', 'CSV data has been imported into the database.');
    }
}
