<template>
    <div>
        <img :src="userImage.data.attributes.path"
             :alt="alt"
             ref="userImage"
             :class="classes">
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import Dropzone from 'dropzone';

    export default {
        name: "UploadableImage",
        props: [
            'userImage',
            'imageWidth',
            'imageHeight',
            'location',
            'classes',
            'alt',
        ],
        data: () => {
            return {
                dropzone: null,
                // uploadedImage: null,
            }
        },
        mounted() {
            // this.dropzone = new Dropzone(this.$refs.userImage, this.settings);
            if (this.authUser.data.user_id.toString() === this.$route.params.userId) {
                this.dropzone = new Dropzone(this.$refs.userImage, this.settings);
            }
        },
        computed: {

            ...mapGetters({
                authUser: 'authUser',
            }),

            settings() {
                return {
                    paramName: 'image',
                    url: '/api/user-images',
                    acceptedFiles: 'image/*',
                    params: {
                        'width': this.imageWidth,
                        'height': this.imageHeight,
                        'location': this.location,
                    },
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    },
                    success: (e, res) => {
                        // this.uploadedImage = res;
                        this.$store.dispatch('fetchAuthUser');
                        this.$store.dispatch('fetchUser', this.$route.params.userId);
                        this.$store.dispatch('fetchUserPosts', this.$route.params.userId);
                    }
                };
            }
            // imageObject() {
            //     return this.uploadedImage || this.userImage;
            // }
        }
    }
</script>

<style scoped>
</style>
