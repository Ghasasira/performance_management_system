<div class="modal-content py-2 px-3">
  <div class="flex justify-center w-full m-2 border-b">
    <h1 class="mb-2">Excellence</h1>
  </div>
  <form action="{{ route('excellence.update',$superviseeId) }}" method="POST">
    @csrf  
    @method('PATCH') {{-- Include CSRF token for this form --}}
    <div class="mb-2 flex justify-content-between">
      <label for="follow-up" class="block text-gray-700 font-medium mb-2">Follow-up & Follow-through</label>
      <input type="number" id="follow-up" name="follow-up" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="fast-to-deliver" class="block text-gray-700 font-medium mb-2">Fast to Deliver </label>
      <input type="number" id="fast-to-deliver" name="fast-to-deliver" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="good-executor" class="block text-gray-700 font-medium mb-2">Good Executor </label>
      <input type="number" id="good-executor" name="good-executor" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="effective-communicator" class="block text-gray-700 font-medium mb-2">Effective Communicator </label>
      <input type="number" id="effective-communicator" name="effective-communicator" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="efficient" class="block text-gray-700 font-medium mb-2">Efficient </label>
      <input type="number" id="efficient" name="efficient" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="competent" class="block text-gray-700 font-medium mb-2">Competent </label>
      <input type="number" id="competent" name="competent" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="detailed-planner" class="block text-gray-700 font-medium mb-2">Detailed Planner </label>
      <input type="number" id="detailed-planner" name="detailed-planner" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="keeps-time" class="block text-gray-700 font-medium mb-2">Keeps Time </label>
      <input type="number" id="keeps-time" name="keeps-time" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <input type="hidden" name="superviseeId" value="{{$superviseeId}}">
    <div class="mt-3 mb-2">
      <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">Submit</button>
    </div>
  </form>
</div>
