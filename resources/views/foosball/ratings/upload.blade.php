<x-foosball_layout>
    <form method="POST" action="/foosball/ratings/upload">
        @csrf
        <input type="file" name="table_csv" accept=".csv">
        <button type="submit">Upload CSV</button>
    </form>
</x-foosball_layout>