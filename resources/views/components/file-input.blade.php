@props(['accept' => 'image/*'])

<div
    x-data="() => {
        return {
            imgsrc: null,
            previewFile() {
                const [file] = this.$refs.myFile.files
                if (file) {
                    this.imgsrc = URL.createObjectURL(file)
                }
            }
        }
    }"
    x-cloak
>
<input
    type="file"
        accept="{{ $accept }}"
        x-ref="myFile"
        @change="previewFile"
        {!! $attributes->merge([
            'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600'
        ]) !!}
        >

        <template x-if="imgsrc">
            <p>
                <img :src="imgsrc" class="imgPreview h-48 rounded-full" />
            </p>
        </template>
</div>

