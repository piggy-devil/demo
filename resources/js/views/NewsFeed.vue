<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />

        <p v-if="newsStatus.postsStatus === 'loading'">Loading posts...</p>

        <Post v-else v-for="(post, postKey) in posts.data" :key="postKey" :post="post" />
    </div>
</template>

<script>
    import NewPost from '../components/posts/NewPost';
    import Post from '../components/posts/Post';
    import { mapGetters } from 'vuex';

    export default {
        name: "NewsFeed",
        components: {
            NewPost,
            Post
        },

        computed: {
            ...mapGetters({
                posts: 'newsPosts',
                newsStatus: 'newsStatus',
            })
        },

        mounted() {
            this.$store.dispatch('fetchNewsPosts');
        }
    }
</script>

<style scoped>
</style>
