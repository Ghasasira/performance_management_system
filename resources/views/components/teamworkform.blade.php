<div class="modal-content py-2 px-3">
  <div class="flex justify-center w-full m-2 border-b">
    <h1 class="mb-2">Team Work</h1>
  </div>
  <form action="{{ route('teamwork.update', $superviseeId) }}" method="POST">
    @csrf  
    @method('PATCH'){{-- Include CSRF token for this form --}}
    <div class="mb-2 flex justify-content-between">
      <label for="availability" class="block text-gray-700 font-medium mb-2">Availability </label>
      <input type="number" id="availability" name="availability" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="discipline" class="block text-gray-700 font-medium mb-2">Discipline </label>
      <input type="number" id="discipline" name="discipline" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="participatory" class="block text-gray-700 font-medium mb-2">Participatory </label>
      <input type="number" id="participatory" name="participatory" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="ownership" class="block text-gray-700 font-medium mb-2">Ownership </label>
      <input type="number" id="ownership" name="ownership" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="good-communicator" class="block text-gray-700 font-medium mb-2">Good Communicator </label>
      <input type="number" id="good-communicator" name="good-communicator" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="interactive-listener" class="block text-gray-700 font-medium mb-2">Interactive Listener </label>
      <input type="number" id="interactive-listener" name="interactive-listener" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="provides-feedback" class="block text-gray-700 font-medium mb-2">Provides Feedback </label>
      <input type="number" id="provides-feedback" name="provides-feedback" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <div class="mb-2 flex justify-content-between">
      <label for="goes-extra-mile" class="block text-gray-700 font-medium mb-2">Goes an Extra Mile </label>
      <input type="number" id="goes-extra-mile" name="goes-extra-mile" min="0" max="10" class="w-1/2 p-2 border border-gray-300 rounded-lg" required>
    </div>
    <input type="hidden" name="superviseeId" value="{{$superviseeId}}">
    <div class="mt-3 mb-2">
      <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">Submit</button>
    </div>
  </form>
</div>
