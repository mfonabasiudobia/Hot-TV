<div>
    @livewire("user.profile.modal.update-profile")
    <section class="bg-black text-white space-y-7">
        @livewire("user.profile.partials.nav")
        
        @if($currentNav === 'profile')
            @livewire("user.profile.profile")
        @else
            @livewire("user.profile.subscription")
        @endif
    </section>
</div>