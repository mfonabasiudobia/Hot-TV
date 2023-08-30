<div>
    @livewire("user.profile.modal.update-profile")
    <section class="bg-black text-white space-y-7">
        @livewire("user.profile.partials.nav")
    
        <div class="container">
            <section>
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>First Name:</span>
                        <strong>{{ user()->first_name }}</strong>
                    </div>
    
                    <button class="font-bold" x-on:click="$dispatch('trigger-file-modal')">Change</button>
                </div>
    
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Last Name:</span>
                        <strong>{{ user()->last_name }}</strong>
                    </div>
    
                    <button class="font-bold" x-on:click="$dispatch('trigger-file-modal')">Change</button>
                </div>
    
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Email:</span>
                        <strong>{{ user()->email }}</strong>
                    </div>
    
                    <button class="font-bold" x-on:click="$dispatch('trigger-file-modal')">Change</button>
                </div>
    
    
                <div class="flex justify-between items-center py-5 border-b border-secondary">
                    <div>
                        <span>Password:</span>
                        <strong>******</strong>
                    </div>
    
                    <button class="font-bold" x-on:click="$dispatch('trigger-file-modal')">Change</button>
                </div>
    
    
            </section>
        </div>
    
    
    </section>
</div>