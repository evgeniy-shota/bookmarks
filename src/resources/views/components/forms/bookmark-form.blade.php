@props(['modalId', 'canDeleted' => false])
@php
    $thumbnailInput = 'thumbnailInput';
@endphp

<div class="flex justify-center items-center w-full">
    <div class="rounded-md bg-gray-600 p-1 w-full">

        <form x-data @@submit.prevent="submitBookmarkForm"
            action="" method="post">
            @csrf

            <div class="flex items-center gap-1">
                <div class="font-medium">Location:
                </div>
                <x-html.icons.folder />
                <div x-text="$store.contexts.currentContext.name"></div>
            </div>

            {{-- link input --}}
            <x-html.formcontrols.fieldset title='Link'>
                <x-slot:field>
                    <x-html.formcontrols.input required id="link"
                        type="text" placeholder="www.youtube.com"
                        x-model="$store.bookmark.link" :state="true" />
                </x-slot:field>
                <x-slot:legend>
                    <x-html.formcontrols.fieldset-legend text="Enter link" />
                </x-slot:legend>
            </x-html.formcontrols.fieldset>

            {{-- name input --}}
            <x-html.formcontrols.fieldset title='Name' class="mb-2">
                <x-slot:field>
                    <x-html.formcontrols.input required id="name"
                        type="text" placeholder="Youtube"
                        x-model="$store.bookmark.name" :state="true" />
                </x-slot:field>
                <x-slot:legend>
                    <x-html.formcontrols.fieldset-legend
                        text="Enter bookmark name" />
                </x-slot:legend>
            </x-html.formcontrols.fieldset>

            {{-- bookmark thumbnail preview --}}
            <div class="font-bold">Thumbnail</div>
            <template x-if="$store.bookmark.thumbnail_id!==null">
                <div class="w-full">
                    {{-- <div class="text-base font-bold mb-1">Thumbnail</div> --}}
                    <div
                        class="border-2 border-dashed rounded-sm border-gray-500 flex justify-between items-center h-32 w-full">
                        <div class="flex-none w-1/2">
                            <x-html.thumbnail id="bookmarkThumbnailPreview"
                                src=""
                                xSrc="$store.bookmark.thumbnail" />
                        </div>
                        <div class="w-1/2" class="flex-none">
                            <x-html.button
                                action="Alpine.store('bookmark').clearThumbnail()">
                                Clear
                            </x-html.button>
                        </div>
                    </div>
                </div>

            </template>

            {{-- file input --}}
            <div x-show="$store.bookmark.thumbnail_id===null">
                <x-html.formcontrols.input-file-drop-down
                    id="{{ $thumbnailInput }}" :required="false" />
            </div>

            {{-- <div class="flex justify-around items-center mt-2">
                <button type="reset"
                    class="btn bg-gray-500 border-gray-600 hover:border-gray-500 text-gray-100 shadow-md">
                    Clear
                </button>

                <button type="submit"
                    class="btn bg-gray-500 border-gray-600 hover:border-gray-500 text-gray-100 shadow-md">
                    Submit
                </button>
            </div> --}}

            <div class="flex gap-4 mt-4 justify-center w-full">
                <x-html.button-out-orange x-show="{{ $canDeleted }}"
                    action="deleteBookmark()">
                    Delete
                </x-html.button-out-orange>

                <x-html.button-out-gray type="reset"
                    action="clearForm({{ $thumbnailInput }})" class="w-1/4">
                    <x-html.icons.x-lg />
                    Clear
                </x-html.button-out-gray>

                <x-html.button-out-green type="submit" class="w-1/4">
                    <x-html.icons.floppy />
                    Save
                </x-html.button-out-green>
            </div>
        </form>

        <script>
            async function submitBookmarkForm() {
                let data = Alpine.store('bookmark').getData()

                if (Alpine.store('bookmark').id === null) {
                    createBookmark(data)
                } else {
                    updateBookmark(data)
                }

            }

            async function createBookmark(data) {
                let result = await submitForm(
                    data,
                    '/bookmarks/',
                    (bookmark) => Alpine.store('contexts').data.push(bookmark))
                console.log(Alpine.store('contexts').data)

                if (result) {
                    {{ $modalId }}.close()
                    closeModal()
                    Alpine.store('alerts').addAlert('Bookmark added successfully',
                        'success')
                } else {
                    Alpine.store('alerts').addAlert('Failed! Bookmark not added!',
                        'warning')
                }
            }

            async function updateBookmark(data) {
                let index = Alpine.store('bookmark').indexInContexts

                let result = await updateRequest(
                    '/bookmarks/' + data.id,
                    data,
                    (bookmark) => Alpine.store('contexts').data.push(bookmark))

                if (result) {
                    Alpine.store('contexts').data[index] = result
                    {{ $modalId }}.close()
                    closeModal()
                    Alpine.store('alerts').addAlert('Bookmark updated successfully',
                        'success')
                } else {
                    Alpine.store('alerts').addAlert('Failed! Bookmark not updated!',
                        'warning')
                }
            }

            async function deleteBookmark() {

                let result = await deleteRequest(
                    '/bookmarks/',
                    Alpine.store('bookmark').id);

                if (result) {

                    Alpine.store('contexts').data.splice(
                        Alpine.store('bookmark').indexInContexts,
                        1);
                    {{ $modalId }}.close()
                    closeModal()
                    Alpine.store('alerts').addAlert('Bookmark removed!', 'success');
                } else {
                    Alpine.store('alerts').addAlert('Failed! Bookmark not removed!',
                        'warning')
                }
            }

            function clearForm(fileInput) {
                console.log(fileInput);
                Alpine.store('bookmark').clearThumbnail()
                Alpine.store('fileInput').clearData(fileInput)
            }
        </script>

    </div>
</div>
