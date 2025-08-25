<?php

namespace App\Livewire\Website;

use App\Models\Gallery;
use App\Models\HomePage;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

class IndexHome extends Component
{



    #[Layout('components.layouts.website')]




    public function render()
    {
        $productCategory = ProductCategory::paginate(9);
        $gallery = Gallery::all();
        $sliders = HomePage::where('section', 'slider')->select('images')->get();
        $about = HomePage::where('section', 'about')->first();


        return view('livewire.website.index-home', [
            'productCategory' => $productCategory,
            'gallery' => $gallery,
            'sliders' => $sliders,
            'about' => $about,
        ]);
    }
}
