<?php

namespace App\Livewire\Settings;

use App\Models\Household;
use Livewire\Component;
use Livewire\Attributes\Validate;

class HouseholdManagement extends Component
{
    #[Validate('required|string|size:8')]
    public $join_code = '';

    public function joinHousehold()
    {
        $this->validate();

        $household = Household::findByShareCode(strtoupper($this->join_code));

        if (!$household) {
            session()->flash('error', 'Invalid share code.');
            return;
        }

        $user = auth()->user();

        if ($user->household_id === $household->id) {
            session()->flash('error', 'You are already in this household.');
            return;
        }

        // If user has existing data, we need to handle it
        if ($user->household_id) {
            session()->flash('error', 'You are already in a household. Please contact support to migrate your data.');
            return;
        }

        // Join the household
        $user->update(['household_id' => $household->id]);

        session()->flash('success', 'Successfully joined household!');
        $this->join_code = '';
    }

    public function render()
    {
        $household = auth()->user()->household;
        $members = $household ? $household->users : collect();

        return view('livewire.settings.household-management', [
            'household' => $household,
            'members' => $members,
        ]);
    }
}
