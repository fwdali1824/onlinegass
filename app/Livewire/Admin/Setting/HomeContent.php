<?php

namespace App\Livewire\Admin\Setting;

use App\Models\HomePage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class HomeContent extends Component
{

    use WithFileUploads;

    public $images = [];
    public $existingSliders;


    public $title, $heading, $content, $points, $image, $existingImage;
    public $aboutId;

    public $whyTitle, $whyHeading, $whyContent;
    public $whyPoints = []; // dynamic features list
    public $whyChooseId;


    public $featureTitle, $featureHeading, $featureContent;
    public $featurePoints = [];


    public $funFacts = [];


    public $quoteSectionTitle;
    public $quoteSectionContent;
    public $quoteSectionPoints = [];
    public $quoteSectionButton1Text;
    public $quoteSectionButton1Link;
    public $quoteSectionButton2Text;
    public $quoteSectionButton2Link;
    public $quoteSectionFormTitle;
    public $quoteSectionFormDescription;
    public $quoteSectionId;








    public function mount()
    {
        $this->existingSliders = HomePage::where('section', 'slider')->get();
        $about = HomePage::where('section', 'about')->first();
        if ($about) {
            $this->aboutId = $about->id;
            $this->title = $about->title;
            $this->heading = $about->heading;
            $this->content = $about->content;
            $this->points = $about->points;
            $this->existingImage = $about->images;
        }

        $why = HomePage::where('section', 'why-choose')->first();

        if ($why) {
            $this->whyChooseId = $why->id;
            $this->whyTitle = $why->title;
            $this->whyHeading = $why->heading;
            $this->whyContent = $why->content;
            $this->whyPoints = json_decode($why->points, true) ?? [];
        }

        // Load existing data for 'our-feature' section
        $feature = HomePage::where('section', 'our-feature')->first();

        if ($feature) {
            $this->featureTitle = $feature->title;
            $this->featureHeading = $feature->heading;
            $this->featureContent = $feature->content;
            $this->featurePoints = json_decode($feature->points ?? '[]', true);
        } else {
            $this->featurePoints = [
                ['icon' => '', 'title' => '', 'description' => '']
            ];
        }


        $funFactSection = HomePage::where('section', 'fun-fact')->first();

        if ($funFactSection) {
            $this->funFacts = json_decode($funFactSection->points ?? '[]', true);
        } else {
            $this->funFacts = [
                ['icon' => 'fi flaticon-worker', 'count' => 20, 'suffix' => '', 'label' => 'Employed'],
                ['icon' => 'fi flaticon-engineer', 'count' => 100, 'suffix' => '', 'label' => 'Producta'],
                ['icon' => 'fi flaticon-trophy', 'count' => 2, 'suffix' => '+', 'label' => 'Award Won'],
                ['icon' => 'fi flaticon-like-1', 'count' => 100, 'suffix' => '%', 'label' => 'Satisfied customers'],
            ];
        }


        // Load Quote Section
        $quote = HomePage::where('section', 'quote')->first();
        if ($quote) {
            $this->quoteSectionId = $quote->id;
            $this->quoteSectionTitle = $quote->title;
            $this->quoteSectionContent = $quote->content;
            $this->quoteSectionPoints = explode(',', $quote->points);
            // You can also add buttons and form data if stored in other columns, e.g. $quote->button1, etc.
        }
    }


    public function saveQuoteSection()
    {
        $validated = $this->validate([
            'quoteSectionTitle' => 'required|string',
            'quoteSectionContent' => 'nullable|string',
            'quoteSectionPoints' => 'array',
            'quoteSectionPoints.*' => 'string|nullable',
            'quoteSectionButton1Text' => 'nullable|string',
            'quoteSectionButton1Link' => 'nullable|string',
            'quoteSectionButton2Text' => 'nullable|string',
            'quoteSectionButton2Link' => 'nullable|string',
            'quoteSectionFormTitle' => 'nullable|string',
            'quoteSectionFormDescription' => 'nullable|string',
        ]);

        HomePage::updateOrCreate(
            ['id' => $this->quoteSectionId],
            [
                'section' => 'quote',
                'title' => $this->quoteSectionTitle,
                'content' => $this->quoteSectionContent,
                'points' =>  $this->quoteSectionPoints,
                'button1' => $this->quoteSectionButton1Text,
                'buttonLink1' => $this->quoteSectionButton1Link,
                'button2' => $this->quoteSectionButton2Text,
                'buttonLink2' => $this->quoteSectionButton2Link,
                // Add more fields as needed for form title/description
            ]
        );

        session()->flash('message', 'Quote section updated successfully!');
    }

    public function addFunFact()
    {
        $this->funFacts[] = ['icon' => '', 'count' => 0, 'suffix' => '', 'label' => ''];
    }

    public function removeFunFact($index)
    {
        unset($this->funFacts[$index]);
        $this->funFacts = array_values($this->funFacts);
    }

    public function saveFunFacts()
    {
        HomePage::updateOrCreate(
            ['section' => 'fun-fact'],
            [
                'points' => json_encode($this->funFacts),
                // you can add title/content if needed
            ]
        );

        session()->flash('message', 'Fun Fact section saved successfully.');
    }

    public function saveFeature()
    {
        $data = [
            'section' => 'our-feature',
            'title' => $this->featureTitle,
            'heading' => $this->featureHeading,
            'content' => $this->featureContent,
            'points' => json_encode($this->featurePoints),
        ];

        HomePage::updateOrCreate(['section' => 'our-feature'], $data);

        session()->flash('message', 'Our Feature section saved successfully.');
    }


    public function addFeaturePoint()
    {
        $this->featurePoints[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeFeaturePoint($index)
    {
        unset($this->featurePoints[$index]);
        $this->featurePoints = array_values($this->featurePoints);
    }

    public function saveOurFeature()
    {
        $data = [
            'section' => 'our-feature',
            'title' => $this->whyTitle,
            'heading' => $this->whyHeading,
            'content' => $this->whyContent,
            'points' => json_encode($this->whyPoints),
        ];

        HomePage::updateOrCreate(['section' => 'our-feature'], $data);

        session()->flash('message', 'Our Feature section saved successfully.');
    }


    public function saveWhyChoose()
    {
        $data = [
            'section' => 'why-choose',
            'title' => $this->whyTitle,
            'heading' => $this->whyHeading,
            'content' => $this->whyContent,
            'points' => json_encode($this->whyPoints),
        ];

        HomePage::updateOrCreate(['section' => 'why-choose'], $data);

        session()->flash('message', 'Why Choose Us section updated successfully.');
    }

    public function addWhyPoint()
    {
        $this->whyPoints[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeWhyPoint($index)
    {
        unset($this->whyPoints[$index]);
        $this->whyPoints = array_values($this->whyPoints); // reindex
    }

    public function Aboutsave()
    {
        $data = [
            'section' => 'about',
            'title' => $this->title,
            'heading' => $this->heading,
            'content' => $this->content,
            'points' => $this->points,
        ];

        if ($this->image) {
            $imagePath = $this->image->store('about', 'public');
            $data['images'] = $imagePath;

            // Optionally delete old image
            if ($this->existingImage && Storage::disk('public')->exists($this->existingImage)) {
                Storage::disk('public')->delete($this->existingImage);
            }

            $this->existingImage = $imagePath;
        }

        HomePage::updateOrCreate(
            ['section' => 'about'],
            $data
        );

        session()->flash('message', 'About section updated successfully.');
    }

    public function addImage()
    {
        $this->images[] = null;
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images); // re-index array
    }

    public function deleteSlider($id)
    {
        $slider = HomePage::find($id);
        if ($slider) {
            Storage::delete('public/' . $slider->images);
            $slider->delete();
            $this->existingSliders = HomePage::where('section', 'slider')->get();
        }
    }

    public function save()
    {
        foreach ($this->images as $upload) {
            if ($upload) {
                $filename = $upload->store('sliders', 'public');

                HomePage::create([
                    'section' => 'slider',
                    'images' => $filename
                ]);
            }
        }

        $this->images = [];
        $this->existingSliders = HomePage::where('section', 'slider')->get();
        session()->flash('message', 'Sliders updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.setting.home-content');
    }
}
