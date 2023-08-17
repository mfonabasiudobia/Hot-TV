 <div class="">
                <span>Filters:</span>
                 <form class="sort-items grid grid-cols-2 md:grid-cols-{!!count($showItems) > 4 ? 4 : 3 !!} gap-5">


                    @if(in_array('sortByLatest',$showItems))
                         <div class="form-group">
                            <select class="form-control appearance-none" wire:model="sortByLatest">
                                <option value="">Sort By Latest </option>
                                <option value="desc">Sort By Newest</option>
                                <option value="asc">Sort By Oldest</option>
                             </select>
                             <i class="las la-angle-down text-brown-100 text-lg absolute top-2 right-5"></i>
                        </div>
                    @endIf


                    @if(in_array('sortByYear',$showItems))
                         <div class="form-group">
                            <select class="form-control appearance-none" wire:model="sortByYear">
                                <option value="">Sort By Year </option>
                                @foreach (range(2020, date("Y")) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                             </select>
                             <i class="las la-angle-down text-brown-100 text-lg absolute top-2 right-5"></i>
                        </div>
                    @endIf



                  {{--   @if(in_array('sortByLatestWithPricePopularity',$showItems))
                         <div class="form-group">
                            <select class="form-control" wire:model="sortByLatestWithPricePopularity">
                                <option value="">Default Sorting </option>
                                <option value="desc">Newest</option>
                                <option value="asc">Oldest</option>
                                <option value="lh">Low to high</option>
                                <option value="hl">High to Low</option>
                             </select>
                             <i class="las la-angle-down text-brown-100 text-lg"></i>
                        </div>
                    @endIf

                     @if(in_array('sortByDeletedItems',$showItems))
                        <div class="form-group">
                            <select class="form-control" wire:model="sortByDeletedItems">
                                <option value="">Published Items</option>
                                <option value="all">All Items</option>
                                <option value="trash">Unpublished Items</option>
                             </select>
                             <i class="las la-angle-down text-brown-100 text-lg"></i>
                        </div>
                    @endIf --}}

                   {{--   @if(in_array('sortByImageCategory',$showItems))
                        <div class="form-group">
                            <select class="form-control" wire:model="sortByImageCategory">
                                <option value="">Image Category</option>
                                @foreach ($this->imageCategories as $category)
                                    <option value="{{$category}}">{{$category}}</option>
                                @endforeach
                             </select>
                             <i class="las la-angle-down text-brown-100 text-lg"></i>
                        </div>
                    @endIf --}}

                    @if(in_array('sortByDate',$showItems))
                        <div class="form-group" wire:ignore>
                            <input type="text" class="form-control custom-date-range" placeholder="Order By Date" wire:model="sortByDate"  />

                            <i class="las la-calendar-alt text-brown-100 text-lg absolute top-2 right-5"></i>
                             
                        </div>
                    @endIf


                    </form>
</div>