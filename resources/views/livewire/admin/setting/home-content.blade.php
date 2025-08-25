<div>
    <div class="card p-5">
        <h3>Slider Images</h3>

        <!-- Show existing sliders -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            @foreach ($existingSliders as $slider)
                <div>
                    <img src="{{ asset('storage/' . $slider->images) }}" class="w-full h-32 object-cover">
                    <button wire:click="deleteSlider({{ $slider->id }})" style="border: none"
                        class="bg-danger mt-2 text-white">Delete</button>
                </div>
            @endforeach
        </div>

        <!-- Upload new images -->
        <h4 class="mt-4 mb-2">Upload New Sliders</h4>
        @foreach ($images as $index => $image)
            <div class="mb-2">
                <input type="file" wire:model="images.{{ $index }}">
                <button wire:click="removeImage({{ $index }})" style="border: none"
                    class="bg-danger text-white">X</button>
            </div>
        @endforeach

        <button wire:click="addImage" style="border: none" class="bg-primary text-white px-4 py-2 rounded">+ Add New
            Slider</button>

        <div class="mt-4">
            <button wire:click="save" style="border: none" class="bg-primary text-white px-4 py-2 rounded">Save</button>
        </div>

        @if (session()->has('message'))
            <div class="text-green-600 mt-2">{{ session('message') }}</div>
        @endif
    </div>

    <div class="card p-4 shadow-sm">
        <div class="card-body">

            <h4 class="card-title mb-4">About Us Section</h4>

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" wire:model.defer="title" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Heading</label>
                <input type="text" wire:model.defer="heading" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea wire:model.defer="content" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Points <small>(Comma separated)</small></label>
                <input type="text" wire:model.defer="points" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>
                @if ($existingImage)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $existingImage) }}" class="img-thumbnail" width="150">
                    </div>
                @endif
                <input type="file" wire:model="image" class="form-control">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button wire:click="Aboutsave" class="btn btn-primary">Save</button>

        </div>
    </div>

    <div class="card p-5">
        <hr class="my-4">

        <h4 class="mb-3">Why Choose Us Section</h4>

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" wire:model.defer="whyTitle" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Heading</label>
            <input type="text" wire:model.defer="whyHeading" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea wire:model.defer="whyContent" class="form-control" rows="3"></textarea>
        </div>

        <h5 class="mt-4 mb-2">Features</h5>

        @foreach ($whyPoints as $index => $point)
            <div class="border p-3 rounded mb-3">
                <div class="mb-2">
                    <label class="form-label">Icon Class</label>
                    <input type="text" wire:model.defer="whyPoints.{{ $index }}.icon" class="form-control"
                        placeholder="e.g., fi flaticon-network-1">
                </div>

                <div class="mb-2">
                    <label class="form-label">Title</label>
                    <input type="text" wire:model.defer="whyPoints.{{ $index }}.title" class="form-control">
                </div>

                <div class="mb-2">
                    <label class="form-label">Description</label>
                    <textarea wire:model.defer="whyPoints.{{ $index }}.description" class="form-control" rows="2"></textarea>
                </div>

                <button type="button" class="btn btn-danger btn-sm"
                    wire:click="removeWhyPoint({{ $index }})">Remove</button>
            </div>
        @endforeach

        <button type="button" class="btn btn-secondary btn-sm mb-3" wire:click="addWhyPoint">+ Add Feature</button>

        <div>
            <button class="btn btn-primary" wire:click="saveWhyChoose">Save Why Choose Us</button>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success mt-2">{{ session('message') }}</div>
        @endif

    </div>


    <div class="card p-5">
        <h4 class="mb-3">Our Feature Section</h4>

        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" wire:model.defer="featureTitle" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Heading</label>
            <input type="text" wire:model.defer="featureHeading" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea wire:model.defer="featureContent" rows="3" class="form-control"></textarea>
        </div>

        <h5 class="mt-4 mb-2">Feature Points</h5>

        @foreach ($featurePoints as $index => $point)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Icon Class</label>
                        <input type="text" wire:model.defer="featurePoints.{{ $index }}.icon"
                            class="form-control" placeholder="e.g. fi flaticon-chip">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" wire:model.defer="featurePoints.{{ $index }}.title"
                            class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea wire:model.defer="featurePoints.{{ $index }}.description" rows="2" class="form-control"></textarea>
                    </div>

                    <button type="button" class="btn btn-danger btn-sm"
                        wire:click="removeFeaturePoint({{ $index }})">
                        Remove
                    </button>
                </div>
            </div>
        @endforeach

        <button type="button" class="btn btn-secondary btn-sm" wire:click="addFeaturePoint">
            + Add Feature
        </button>

        <div class="mt-3">
            <button class="btn btn-primary" wire:click="saveFeature">Save Our Feature</button>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success mt-2">{{ session('message') }}</div>
        @endif

    </div>

    <div class="card p-4 mb-4">
        <h4>Fun Facts Section</h4>

        @foreach ($funFacts as $index => $fact)
            <div class="mb-3 border p-3 rounded">
                <div class="mb-2">
                    <label>Icon Class</label>
                    <input type="text" wire:model.defer="funFacts.{{ $index }}.icon" class="form-control"
                        placeholder="e.g. fi flaticon-worker">
                </div>
                <div class="mb-2">
                    <label>Count</label>
                    <input type="number" wire:model.defer="funFacts.{{ $index }}.count"
                        class="form-control">
                </div>
                <div class="mb-2">
                    <label>Suffix</label>
                    <input type="text" wire:model.defer="funFacts.{{ $index }}.suffix"
                        class="form-control" placeholder="e.g. + or % or empty">
                </div>
                <div class="mb-2">
                    <label>Label</label>
                    <input type="text" wire:model.defer="funFacts.{{ $index }}.label"
                        class="form-control">
                </div>

                <button class="btn btn-danger btn-sm" wire:click="removeFunFact({{ $index }})">Remove</button>
            </div>
        @endforeach

        <button class="btn btn-secondary btn-sm mb-3" wire:click="addFunFact">+ Add Fun Fact</button>

        <br>
        <button class="btn btn-primary" wire:click="saveFunFacts">Save Fun Facts</button>

        @if (session()->has('message'))
            <div class="alert alert-success mt-2">{{ session('message') }}</div>
        @endif
    </div>


    <div class="card mb-5 p-4">
        <h3>Quote Section</h3>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" wire:model.defer="quoteSectionTitle" class="form-control">
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea wire:model.defer="quoteSectionContent" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label>Points (Comma separated)</label>
            <input type="text" wire:model.defer="quoteSectionPointsString" class="form-control"
                wire:model.lazy="quoteSectionPointsString">
            <small>Use commas to separate points</small>
        </div>

        <div class="mb-3">
            <label>Button 1 Text</label>
            <input type="text" wire:model.defer="quoteSectionButton1Text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Button 1 Link</label>
            <input type="text" wire:model.defer="quoteSectionButton1Link" class="form-control">
        </div>

        <div class="mb-3">
            <label>Button 2 Text</label>
            <input type="text" wire:model.defer="quoteSectionButton2Text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Button 2 Link</label>
            <input type="text" wire:model.defer="quoteSectionButton2Link" class="form-control">
        </div>

        <button wire:click="saveQuoteSection" class="btn btn-primary">Save Quote Section</button>
    </div>


</div>
