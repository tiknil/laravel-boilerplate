<?php

namespace App\Livewire;

use App\Models\Audit;
use Livewire\Component;

class AuditEventsDetailModal extends Component
{
    public ?Audit $audit = null;

    public function render()
    {
        return view('backend.audit-events.audit-detail-modal');
    }

    public function setData($id)
    {
        $this->audit = Audit::find($id);
    }

    public function resetModal()
    {
        $this->audit = null;
    }
}
