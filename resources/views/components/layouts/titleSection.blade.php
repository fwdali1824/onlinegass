{{-- Accept props --}}
@props(['title' => 'Default Title', 'subtitle' => null, 'breadcrumbs' => []])

<div class="block-header">
    <div class="row">
        <div class="col-lg-5 col-md-8 col-sm-12">
            <h2>
                <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i>
                </a>
                {{ $title }}
            </h2>

            @if (!empty($breadcrumbs))
                <ul class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                            @if (!empty($breadcrumb['url']) && !$loop->last)
                                <a href="{{ $breadcrumb['url'] }}">
                                    {!! $breadcrumb['icon'] ?? '' !!} {{ $breadcrumb['label'] }}
                                </a>
                            @else
                                {!! $breadcrumb['icon'] ?? '' !!} {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
