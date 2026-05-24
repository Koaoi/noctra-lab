@if(session('success') || session('error') || session('info'))
<div aria-live="polite" aria-atomic="true"
     style="position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; min-width: 280px;">

    @if(session('success'))
    <div class="toast toast-noctra show" role="alert">
        <div class="toast-header">
            <strong class="me-auto" style="font-size:12px; letter-spacing:.06em; text-transform:uppercase;">
                ✓ Success
            </strong>
            <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="font-size:14px;">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast toast-noctra show" role="alert">
        <div class="toast-header" style="border-bottom-color: var(--noctra-red);">
            <strong class="me-auto" style="font-size:12px; letter-spacing:.06em; text-transform:uppercase; color: var(--noctra-red);">
                ✕ Error
            </strong>
            <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="font-size:14px;">
            {{ session('error') }}
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="toast toast-noctra show" role="alert">
        <div class="toast-header">
            <strong class="me-auto" style="font-size:12px; letter-spacing:.06em; text-transform:uppercase;">
                ℹ Info
            </strong>
            <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" style="font-size:14px;">
            {{ session('info') }}
        </div>
    </div>
    @endif

</div>
@endif