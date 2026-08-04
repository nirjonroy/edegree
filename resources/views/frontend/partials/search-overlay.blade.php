<div class="fixed inset-0 bg-ink bg-opacity-70 z-50 mega-menu-blur flex items-start justify-center pt-24 px-4"
     x-show="$store.global.searchModalOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;"
     @keydown.escape.window="$store.global.searchModalOpen = false">
    <div class="bg-white rounded-custom w-full max-w-lg md:max-w-2xl mx-auto overflow-hidden shadow-2xl border border-borderGray" @click.away="$store.global.searchModalOpen = false">
        <div class="p-6 border-b border-borderGray flex justify-between items-center">
            <p class="font-heading font-bold text-ink text-lg">Search Marketplace</p>
            <button @click="$store.global.searchModalOpen = false" class="text-charcoal hover:text-brand-red focus:outline-none">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <div class="flex border-b border-borderGray">
            <button id="search-tab-programs" class="flex-1 text-center py-3 text-sm font-semibold border-b-2 border-brand-red text-brand-red focus:outline-none">
                Programs
            </button>
            <button id="search-tab-universities" class="flex-1 text-center py-3 text-sm font-semibold border-b-2 border-transparent text-charcoal hover:text-brand-red focus:outline-none">
                Universities
            </button>
        </div>

        <div class="p-6">
            <div class="relative">
                <input type="text" id="search-input" placeholder="Type course names, domains or universities..."
                       class="w-full pl-12 pr-4 py-3.5 bg-altBg border border-borderGray rounded-lg text-ink placeholder-mutedGray focus:ring-2 focus:ring-brand-red focus:border-transparent focus:outline-none transition-all duration-150">
                <i data-lucide="search" class="w-5 h-5 text-mutedGray absolute left-4 top-1/2 transform -translate-y-1/2"></i>
            </div>
            <ul id="search-suggestions" class="mt-4 space-y-1 max-h-60 overflow-y-auto"></ul>
        </div>
    </div>
</div>
