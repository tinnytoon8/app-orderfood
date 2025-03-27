<div x-data="{ open: false }">
    <livewire:components.page-title-nav
        :title="'All Menus'"
        wire:key="{{ str()->random(50) }}"
    ></livewire:components.page-title-nav>

    <div class="container mb-24 grid grid-cols-2 items-center gap-4">
        @if (isset($filteredProducts) && count($filteredProducts) > 0)
            @foreach ($filteredProducts as $menu)
                <livewire:components.food-card
                    wire:key="{{ str()->random(50) }}"
                    :data="$menu"
                    :categories="$categories"
                />
            @endforeach
        @else
            <div class="col-span-2 my-2 w-full">
                <p class="text-center text-black-70">No menu available</p>
            </div>
        @endif
    </div>

    <div x-show="open">
        <livewire:components.filter-modal
            :selectedCategories="$selectedCategories"
            :categories="$categories"
            wire:key="{{ str()->random(50) }}"
        />
    </div>
</div>
