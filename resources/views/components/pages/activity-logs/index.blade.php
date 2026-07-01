<?php

use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

new class extends Component
{
    public Collection $activities;

    public function mount(): void
    {
        $this->activities = Activity::query()
            ->with(['causer', 'subject'])
            ->latest()
            ->limit(25)
            ->get();
    }

    public function formatValue(mixed $value): string
    {
        if ($value === null) {
            return '-';
        }

        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        return (string) $value;
    }
};
?>

<div class="p-6">
    <h1>Activity Logs</h1>

    <div class="mt-4">
        @forelse ($activities as $history)
            <div class="mb-6 border-b pb-4">
                <div>
                    <strong>{{ $history->description }}</strong>
                    <span>{{ $history->created_at?->format('Y-m-d H:i:s') }}</span>
                </div>

                <div>Log: {{ $history->log_name }}</div>
                <div>Event: {{ $history->event }}</div>
                <div>Subject: {{ class_basename($history->subject_type) }} #{{ $history->subject_id }}</div>

                @php
                    $changes = $history->attribute_changes->isNotEmpty()
                        ? $history->attribute_changes
                        : $history->properties;
                @endphp

                @foreach (($changes['attributes'] ?? []) as $key => $new)
                    @php
                        $old = $changes['old'][$key] ?? null;
                    @endphp

                    <div>
                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                        {{ $this->formatValue($old) }} -> {{ $this->formatValue($new) }}
                    </div>
                @endforeach
            </div>
        @empty
            <div>No activity logs found.</div>
        @endforelse
    </div>
</div>
