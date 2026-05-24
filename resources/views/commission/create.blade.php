@extends('layouts.app')

@section('title', 'Request Commission')

@section('content')
<div class="container" style="padding-top:3rem; padding-bottom:5rem;">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="mb-4">
                <p class="noctra-label mb-1">New</p>
                <h1 style="font-size:clamp(1.5rem,3vw,2.5rem); font-weight:900;
                           letter-spacing:-.03em; text-transform:uppercase; margin:0;">
                    Commission Request
                </h1>
            </div>

            @if($errors->any())
            <div style="background:rgba(229,62,62,.1); border:1px solid rgba(229,62,62,.3);
                        padding:.875rem 1rem; margin-bottom:1.5rem;">
                <ul class="mb-0 ps-3" style="font-size:13px; color:#fc8181;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('commission.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label-noctra">Commission Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="form-control form-control-noctra"
                           placeholder="e.g. Custom Oversized Hoodie — Dark Theme"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label-noctra">Description *</label>
                    <textarea name="description" rows="5"
                              class="form-control form-control-noctra"
                              placeholder="Jelaskan detail desain yang kamu inginkan: warna, cut, detail, inspirasi, dll."
                              required>{{ old('description') }}</textarea>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label-noctra">Size Preference</label>
                        <input type="text" name="size_preference"
                               value="{{ old('size_preference') }}"
                               class="form-control form-control-noctra"
                               placeholder="e.g. Oversize M, Fitted L">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-noctra">Color Preference</label>
                        <input type="text" name="color_preference"
                               value="{{ old('color_preference') }}"
                               class="form-control form-control-noctra"
                               placeholder="e.g. All Black, Monochrome">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label-noctra">Budget (Rp)</label>
                    <input type="number" name="budget" value="{{ old('budget') }}"
                           class="form-control form-control-noctra"
                           placeholder="e.g. 500000">
                </div>

                <div class="mb-4">
                    <label class="form-label-noctra">Reference Image</label>
                    <div id="uploadArea"
                         style="border:1px dashed var(--noctra-border); padding:2rem;
                                text-align:center; cursor:pointer; transition:border-color .2s;
                                background:var(--noctra-card);">
                        <p style="color:var(--noctra-gray); font-size:13px; margin:0 0 .5rem;">
                            Click to upload reference image
                        </p>
                        <p style="color:var(--noctra-muted); font-size:11px; margin:0;">
                            JPG, PNG, WEBP — Max 2MB
                        </p>
                        <input type="file" name="reference_image" id="fileInput"
                               accept="image/*"
                               style="display:none;">
                    </div>
                    <div id="previewWrap" style="display:none; margin-top:.75rem;">
                        <img id="previewImg" src=""
                             style="max-height:200px; border:1px solid var(--noctra-border);">
                    </div>
                </div>

                <button type="submit" class="btn-noctra w-100"
                        style="display:block; text-align:center;">
                    Submit Commission Request
                </button>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('uploadArea').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});
document.getElementById('fileInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('previewImg');
        preview.src = ev.target.result;
        document.getElementById('previewWrap').style.display = 'block';
        document.getElementById('uploadArea').style.borderColor = 'var(--noctra-white)';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush