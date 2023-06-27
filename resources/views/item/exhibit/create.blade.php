<x-app-layout>
    <x-header>
        {{ __('Exhibit') }}
    </x-header>

    <div x-data="{
        open: false,
        addImage: {
            count: 0,
            uploaded: {},
            countUp() {
                this.uploaded[this.count + 1] = false;
                this.count++;
            },
            remove() {
                delete this.uploaded[this.count];
                this.count--;
            },
        },
    }">

        <div x-show="open" x-ref="modal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ __('Submit Confirmation') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ __('Are you sure you want to submit the form?') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button" @click="open = false" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:text-sm">
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" @click="$refs.form.submit()" class="mt-3 inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:text-sm">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    
        <x-card>
            <form method="POST" action="{{ route('item.exhibit.store') }}" enctype="multipart/form-data" x-ref="form">
                @csrf
    
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
                        <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
                </div>
    
                <!-- Price -->
                <div>
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" min="0" autofocus />
                    <x-input-error :messages="$errors->get('price')" for="price" class="mt-2" />
                </div>
    
                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" autofocus/>
                    <x-input-error :messages="$errors->get('description')" for="description" class="mt-2" />
                </div>
    
                <!-- Quantity -->
                <div>
                    <x-input-label for="quantity" :value="__('Quantity')" />
                    <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" min="0" autofocus />
                    <x-input-error :messages="$errors->get('quantity')" for="quantity" class="mt-2" />
                </div>
    
                <!-- Categories -->
                <div>
                    <x-input-label for="categories" :value="__('Categories')" />
                    <select id="categories" class="block mt-1 w-full" name="categories[]" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @if (in_array($category->slug, old('categories', []))) selected @endif >{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categories')" for="categories" class="mt-2" />
                </div>
                <!-- Images -->
                <div>
                    <x-input-label for="main-image" :value="__('Main Image')" />
                    <x-file-input id="main-image" class="block mt-1" name="images[]" autofocus/>
                </div>
                    <!-- livewireを導入していないため、x-label-inputやx-file-inputを使うことができないが、ここでは問題ないものとする -->
                <div x-data="addImage">
                    <template x-for="i in count" :key="i">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-text="`Ohter Image ${i}`">
                            </label>
                            <div
                                x-data="{
                                    imgsrc: null,
                                    previewFile() {
                                        const [file] = this.$refs.myFile.files
                                        if (file) {
                                            this.imgsrc = URL.createObjectURL(file)
                                            uploaded[i] = true;
                                        }
                                    }
                                }"
                                x-cloak
                                >
                                <input
                                    type="file"
                                    accept="image/*"
                                    x-ref="myFile"
                                    @change="previewFile"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600"
                                    :name="`images[]`"
                                    autofocus
                                    >
                                    <button 
                                        type="button"
                                        @click="remove()"
                                    >
                                    {{ __("Remove") }}
                                    </button>
                                    <template x-if="imgsrc">
                                        <p>
                                            <img :src="imgsrc" class="imgPreview h-48 rounded-full" />
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <button type="button" class="mt-4" x-on:click="() => { countUp(); }" x-show="(count === 0 || uploaded[count]) && count < 3">
                    {{ __('Add More Images') }}
                    </button>
                </div>
    
                <x-primary-button type="button" @click="open = true" class="mt-4">
                    {{ __('Exhibit') }}
                </x-primary-button>
            </form>
        </x-card>
    </div>

</x-app-layout>
