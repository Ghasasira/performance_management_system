<div class="modal-content py-2 px-3">
  <div class="flex justify-center w-full m-2 border-b">
    <h1 class="mb-2">Integrity</h1>
  </div>
  <form action="{{ route('integrity.update', $superviseeId) }}" method="POST">
    @csrf  
    @method('PATCH'){{-- Include CSRF token for this form --}}
    <div class="mb-2 flex justify-content-between">
      <label for="honesty" class="block text-gray-700 font-medium mb-2">Honesty </label>
      <input type="number" id="honesty" name="honesty" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="trustworthy" class="block text-gray-700 font-medium mb-2">Trustworthy </label>
      <input type="number" id="trustworthy" name="trustworthy" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="reliable" class="block text-gray-700 font-medium mb-2">Reliable </label>
      <input type="number" id="reliable" name="reliable" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="truth-telling" class="block text-gray-700 font-medium mb-2">Truth-telling </label>
      <input type="number" id="truth-telling" name="truth-telling" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="accountable" class="block text-gray-700 font-medium mb-2">Accountable </label>
      <input type="number" id="accountable" name="accountable" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="loyal" class="block text-gray-700 font-medium mb-2">Loyal </label>
      <input type="number" id="loyal" name="loyal" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <input type="hidden" name="superviseeId" value="{{$superviseeId}}">
    <div class="mt-3 mb-2">
      <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">Submit</button>
    </div>
  </form>
</div>
