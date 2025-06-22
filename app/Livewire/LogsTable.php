<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Log as LogModel;

class LogsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $typeLog = '';
    public $source = '';

    protected $updatesQueryString = ['search', 'typeLog', 'source', 'page'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingTypeLog() { $this->resetPage(); }
    public function updatingSource() { $this->resetPage(); }

    public function render()
    {
        $logs = LogModel::query()
            ->when(filled($this->typeLog), function ($query) {
                $query->whereRaw('UPPER(type_log) = ?', [strtoupper($this->typeLog)]);
            })
            ->when(filled($this->source), function ($query) {
                $query->where('source', 'like', "%{$this->source}%");
            })
            ->when(filled($this->search), function ($query) {
                $query->where(function ($q) {
                    $q->where('log', 'like', "%{$this->search}%")
                    ->orWhere('textobs', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.logs-table', [
            'logs' => $logs,
        ])->layout('components.layouts.app', ['title' => 'Logs']);
    }
}
