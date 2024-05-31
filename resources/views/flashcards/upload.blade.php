<x-flashcards_layout>


    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4  custom-card-container">
            <h2 class="text-center mb-4">Upload Flashcards</h2>
            <form method="POST" action="/flashcards/upload" enctype="multipart/form-data">
                @csrf
                <div class="form-floating mb-3">
                    @if($errors->has('subject'))
                        <input type="text" name='subject' value="{{old('subject')}}" class="form-control is-invalid" id="subject">
                        @error('subject')
                            <label style="font-weight:bold;" for="subject">Subject - {{$message}}</label>
                        @enderror
                    @else
                        <input class="form-control" type="text" value="" id="subject" name="subject">
                        <label style="font-weight:bold;" for="subject">Subject</label>
                    @endif
                </div>

                @error('flashcard_data')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <div class="form-floating mb-3" style="width:100%;">
                    <input type="file" name="flashcard_data" accept=".csv">
                </div>
                
                <button type="submit" class="btn btn-danger w-100">Upload</button>
            </form>
        </div>
    </div>
</x-flashcards_layout>