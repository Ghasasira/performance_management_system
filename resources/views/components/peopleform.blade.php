<div class="modal-content py-2 px-3">
  <div class="flex justify-center w-full m-2 border-b">
    <h1 class="mb-2">People</h1>
  </div>
  <form action="{{ route('people.update', $superviseeId) }}" method="POST">
    @csrf  
    @method('PATCH'){{-- Include CSRF token for this form --}}
    <div class="mb-2 flex justify-content-between">
      <label for="interpersonal-skills" class="block text-gray-700 font-medium mb-2">Interpersonal Skills </label>
      <input type="number" id="interpersonal-skills" name="interpersonal-skills" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="respectful" class="block text-gray-700 font-medium mb-2">Respectful </label>
      <input type="number" id="respectful" name="respectful" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="flexible" class="block text-gray-700 font-medium mb-2">Flexible </label>
      <input type="number" id="flexible" name="flexible" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="emotionally-intelligent" class="block text-gray-700 font-medium mb-2">Emotionally Intelligent </label>
      <input type="number" id="emotionally-intelligent" name="emotionally-intelligent" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="positive-attitude" class="block text-gray-700 font-medium mb-2">Positive Attitude </label>
      <input type="number" id="positive-attitude" name="positive-attitude" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="considerate" class="block text-gray-700 font-medium mb-2">Considerate </label>
      <input type="number" id="considerate" name="considerate" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="courteous" class="block text-gray-700 font-medium mb-2">Courteous </label>
      <input type="number" id="courteous" name="courteous" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <input type="hidden" name="superviseeId" value="{{$superviseeId}}">
    <div class="mt-3 mb-2">
      <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">Submit</button>
    </div> 
  </form>
</div>
