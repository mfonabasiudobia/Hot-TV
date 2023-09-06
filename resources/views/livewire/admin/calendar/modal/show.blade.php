<div class="modal-wrapper" x-data="{ status : false, title : '', description : '', start : '', end : '', id : 0 }"
    @trigger-show-stream-modal.window="status = !status;
        title = event.detail.title;
        description = event.detail.description;
        id = event.detail.id;
        start = moment(event.detail.start).format('D MMM YYYY H:mm A');
        end = moment(event.detail.end).format('D MMM YYYY H:mm A');
    "
    @trigger-close-modal.window="status = false" x-show="status" x-cloak>
    <x-loading />
    <section class="modal-inner-wrapper">
        <section class="modal-body rounded-lg shadow w-full md:w-1/2 z-[1005] px-5 space-y-3 bg-white"
            @click.outside="status = false">

            <h1 x-text="title">jddhdhhd</h1>

            <ul>
                <li>
                    <strong>Start Date:</strong>
                    <span x-text="start"></span>
                </li>
                <li>
                    <strong>End Date:</strong>
                    <span x-text="end"></span>
                </li>
            </ul>

            <p x-html="description"></p>

            <div class="flex space-x-5 text-sm items-center">
                <a :href="'/admin/video/' + id + '/edit'" class="text-primary">Edit</a>
                
                <a href="javascript:void(0)" x-on:click="$dispatch('trigger-delete-modal', {
                                                                                        'id' : id,
                                                                                        'model' : '\App\\Models\\Stream',
                                                                                        'title' : 'Are you sure?',
                                                                                        'message' : 'Are you sure you want to delete this stream from the pool?'
                                                            })" class="text-danger">Delete</a>
            </div>
           
        </section>

    </section>


</div>
