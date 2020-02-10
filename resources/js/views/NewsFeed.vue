<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />

        <Post />
    </div>
</template>

<script>
    import NewPost from '../components/posts/NewPost';
    import Post from '../components/posts/Post';

    export default {
        name: "NewsFeed",
        components: {
            NewPost,
            Post
        }
    }
</script>

<style scoped>
</style>
