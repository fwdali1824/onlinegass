<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div wire:ignore>


        <label for="user-select" class="block font-semibold mb-2">Select Users:</label>
        <select id="user-select" multiple="multiple" class="form-control w-full" style="width: 100%">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
    </div>

    <!-- Selected users preview -->
    <div class="mt-4">
        <h3 class="font-semibold mb-1">Selected Users:</h3>
        <ul class="list-disc pl-5">
            @foreach ($selectedUsers as $userId)
                @php
                    $user = $users->firstWhere('id', $userId);
                @endphp
                @if ($user)
                    <li>{{ $user->name }} ({{ $user->email }})</li>
                @endif
            @endforeach
        </ul>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            const select = $('#user-select');

            function initSelect2() {
                select.select2({
                    placeholder: "Select users",
                    allowClear: true,
                });

                // Set current Livewire selected users on Select2 after init
                select.val(@this.get('selectedUsers')).trigger('change');

                // When selection changes, update Livewire
                select.off('change').on('change', function(e) {
                    const data = $(this).val();
                    @this.set('selectedUsers', data);
                });
            }

            initSelect2();

            Livewire.hook('message.processed', (message, component) => {
                // Destroy before reinit to avoid duplicate DOM
                if (select.hasClass("select2-hidden-accessible")) {
                    select.select2('destroy');
                }
                initSelect2();
            });
        });
    </script>


</div>
