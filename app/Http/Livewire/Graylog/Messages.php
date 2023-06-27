<?php

namespace App\Http\Livewire\Graylog;

use Livewire\Component;
use App\Libraries\Graylog;
use Illuminate\Support\Collection;

class Messages extends Component
{
    public Collection $messages;
    public Collection $filteredMessages;
    public array $savedSearches = [];
    public array $selectedSavedSearch = [];
    public string $searchId = '';
    public string $search = '';

    public bool $live = true;

    protected $queryString = ['searchId', 'search'];

    public function mount()
    {
        $graylog = new Graylog();
        $this->savedSearches = $graylog->getSavedSearches()['views'] ?? [];
        $this->searchId = $this->searchId ?? $this->savedSearches[0]['search_id'] ?? null;
        $this->messages = collect();
        $this->filteredMessages = $this->messages;
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.graylog.messages');
    }

    public function updatingSearch(string $search)
    {
        if ($search !== '') {
            $this->filteredMessages = $this->messages->filter(function ($message) {
                return str_contains(json_encode($message['message']), $this->search);
            });
        } else {
            $this->filteredMessages = $this->messages;
        }
    }

    public function updatingSearchId(string $searchId): void
    {
        $this->messages = collect();
        $this->loadMessages($searchId);
    }

    public function loadMessages(string $searchId = null): void
    {
        $graylog = new Graylog();
        if ($this->searchId) {
            $results = $graylog->getSavedSearchMessages($searchId ?? $this->searchId)['results'];
            $result = array_shift($results)['search_types'];
            $newMessages = collect();
            foreach ($result as $searchType) {
                if (array_key_exists('messages', $searchType)) {
                    $newMessages = collect($searchType['messages']);
                    break;
                }
            }
            $this->messages = collect($newMessages)->concat($this->messages);

            if ($this->search) {
                $this->filteredMessages = $this->messages->filter(function ($message) {
                    return str_contains(json_encode($message['message']), $this->search);
                });
            } else {
                $this->filteredMessages = $this->messages;
            }
        }
    }
}
