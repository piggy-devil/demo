<template>
    <div class="uploader"
        @dragenter="OnDragEnter"
        @dragleave="OnDragLeave"
        @dragover.prevent
        @drag="onDrop"
        :class="{ dragging: isDragging }"
        >
        <i class="fa fa-cloud-upload"></i>
        <p>Drag your image here</p>
        <div>OR</div>
        <div class="file-input">
            <label for="file">Select a file</label>
            <input type="file" id="file" @change="onInputChange" multiple>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ImageUploader",
        data: () => ({
            isDragging: false,
            dragCount: 0
        }),
        methods: {
            OnDragEnter(e) {
                e.preventDefault();
                this.dragCount++;
                this.isDragging = true;
                return false;
            },
            OnDragLeave(e) {
                e.preventDefault()
                this.dragCount--
                if (this.dragCount <= 0)
                    this.isDragging = false
            },
            onInputChange(e) {
                console.log(e)
            },
            onDrop(e) {
                e.preventDefault();
                e.stopPropagation();
                this.isDragging = false;
                const files = e.dataTransfer.files;
                console.log(files)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .uploader {
        width: 100%;
        background: #2196F3;
        color: #fff;
        padding: 40px 15px;
        text-align: center;
        border-radius: 10px;
        border: 3px dashed #fff;
        font-size: 20px;
        position: relative;
        &.dragging {
            background: #fff;
            color: #2196F3;
            border: 3px dashed #2196F3;
            .file-input label {
                background: #2196F3;
                color: #fff;
            }
        }
        i {
            font-size: 85px;
        }
    }
</style>
