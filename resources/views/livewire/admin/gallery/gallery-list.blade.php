<div>
    {{-- Title --}}
    <div class="card mb-4">
        <div class="d-flex justify-content-between align-items-center m-3">
            <h4 class="mb-0">Gallery</h4>
        </div>
    </div>

    {{-- Dropzone --}}
    <form action="#" id="dropzoneArea" class="dropzone border rounded p-3 text-center mb-4">
        <div class="dz-message">
            <span>Drop files here or click to upload</span>
        </div>
    </form>

    {{-- Gallery --}}
    <div class="row">
        @foreach ($uploadedImages as $item)
            <div class="col-md-3 mb-3 position-relative">
                <button wire:click="delete({{ $item->id }})"
                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                        style="z-index: 10;">&times;</button>
                <img src="{{ Storage::url($item->image) }}" class="img-fluid rounded border" />
            </div>
        @endforeach
    </div>

    {{-- Error --}}
    @error('image')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    {{-- Dropzone CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">

    {{-- Dropzone JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        const dz = new Dropzone("#dropzoneArea", {
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 10,
            maxFilesize: 2, // MB
            acceptedFiles: 'image/*',
            init: function () {
                this.on("addedfile", file => {
                    @this.upload(
                        'image',
                        file,
                        (tmpPath) => {
                            @this.call('uploadSingle', tmpPath);
                        },
                        (err) => {
                            console.error('Upload error:', err);
                        },
                        (progress) => {
                            console.log('Upload progress:', progress);
                        }
                    );
                });
            }
        });
    </script>
</div>
