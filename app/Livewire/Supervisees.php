<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Quarter;
use Illuminate\Support\Facades\Auth;

class Supervisees extends Component
{
    use WithPagination;

    public $search = '';
    public $quarters;
    public $perPage = 10; // Items per page

    public function mount()
    {
        $currentUser = Auth::user();

        // Check if the user is authorized
        if (!in_array($currentUser->classification_name, ['exco', 'tmt', 'smt'])) {
            abort(401, 'User is not authorized to view this page');
        }

        // Fetch all quarters
        $this->quarters = Quarter::get();
    }

    public function render()
    {
        $currentUser = Auth::user();

        // Base query (do not execute with ->get() yet)
        $query = User::query()
            ->where('userId', '!=', $currentUser->userId)
            ->with('job');

        // Apply conditions based on user role
        if (strtolower($currentUser->job->job_name) == "group ceo") {
            $query->whereIn('classification_name', ['tmt', 'exco']);
        } elseif (strtolower($currentUser->job->job_name) == "chief operations officer") {
            // COO can only see users in department_id 1 and 2 (adjust as needed)
            // $query->whereIn('department_id', [1, 15]);
            $query->whereIn('classification_name', ['tmt', 'exco']);
        } elseif (strtolower($currentUser->job->job_name) != "chief of staff") {
            $query->where('department_id', $currentUser->department_id);

            // Apply classification filters
            if ($currentUser->classification_name == 'exco') {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['exco']);
                });
            } elseif ($currentUser->classification_name == 'tmt') {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['tmt', 'exco']);
                });
            } elseif ($currentUser->classification_name == 'smt') {
                $query->where(function ($q) {
                    $q->whereNull('classification_name')
                        ->orWhereNotIn('classification_name', ['smt', 'tmt']);
                });
            }
        }

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('firstName', 'like', '%' . $this->search . '%')
                    ->orWhere('lastName', 'like', '%' . $this->search . '%')
                    ->orWhereHas('job', function ($q) {
                        $q->where('job_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Execute query with pagination
        $filteredSupervisees = $query->paginate($this->perPage);

        // Check if supervisees are found
        // if ($filteredSupervisees->isEmpty()) {
        //     // abort(404, 'No supervisees found');
        // }

        return view('livewire.supervisees', [
            'filteredSupervisees' => $filteredSupervisees,
            'quarters' => $this->quarters,
        ]);
    }
}
