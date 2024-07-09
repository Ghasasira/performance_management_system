<div class="modal-content py-2 px-3">
  <div class="flex justify-center w-full m-2 border-b">
    <h1 class="mb-2">Equity</h1>
  </div>
<form action="{{ route('equity.update',$superviseeId) }}" method="POST">
  @csrf 
  @method('PATCH') {{-- Include CSRF token for this form --}}
  <div class="mb-2 flex justify-content-between">
    <label for="fair" class="block text-gray-700 font-medium mb-2">Fairness </label>
    <input type="number" id="fair" name="fair" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
  </div>
  <div class="mb-2 flex justify-content-between">
      <label for="equal_opportunity" class="block text-gray-700 font-medium mb-2">Equal Opportunity </label>
      <input type="number" id="equal_opportunity" name="equal_opportunity" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
  </div>
  <div class="mb-2 flex justify-content-between">
      <label for="non_tribalism" class="block text-gray-700 font-medium mb-2">Non-tribalism </label>
      <input type="number" id="non_tribalism" name="non_tribalism" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
  </div>
  <div class="mb-2 flex justify-content-between">
      <label for="non_nepotism" class="block text-gray-700 font-medium mb-2">Non-nepotism </label>
      <input type="number" id="non_nepotism" name="non_nepotism" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
  </div>
  <div class="mb-2 flex justify-content-between">
      <label for="gender_blind" class="block text-gray-700 font-medium mb-2">Gender Blindness </label>
      <input type="number" id="gender_blind" name="gender_blind" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
  </div>
  <div class="mb-2 flex justify-content-between">
      <label for="ethnic_blind" class="block text-gray-700 font-medium mb-2">Ethnic Blindness </label>
      <input type="number" id="ethnic_blind" name="ethnic_blind" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
  </div>
  <input type="hidden" name="superviseeId" value="{{$superviseeId}}">
  <div class="mt-3 mb-2">
      <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">Submit</button>
  </div>
</form>
</div>
