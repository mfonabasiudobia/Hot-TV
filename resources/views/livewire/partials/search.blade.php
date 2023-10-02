<div 
class="modal-wrapper text-white p-5 flex items-center justify-center bg-opacity-80" 
x-data="{ status : false }" 
@trigger-search-modal.window="status = !status;"
@trigger-close-modal.window="status = false" 
x-show="status" 
x-transition.duration.500ms 
@click.outside="status = false"
x-cloak>

    <button class="text-2xl absolute top-5 right-5" x-on:click.prevent="status = !status">
        <i class="las la-times"></i>
    </button>
    
    <form action="{{ route('search') }}" class="w-full">
        <div class="form-group">
            <input type="text" class="w-full bg-transparent border-0 focus:outline-0 py-3 text-xl rounded-lg" name="q" placeholder="Search Titles here..." autofocus="true" />
        </div>
    </form>
</div>