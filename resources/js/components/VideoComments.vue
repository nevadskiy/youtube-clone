<template>
    <div>
        <p>{{ comments.length }} {{ comments.length === 1 ? 'comment' : 'comments' }}</p>
        <ul class="list-unstyled">
            <li v-for="comment in comments" :key="comment.id" class="media">
                <a :href="'/channel/' + comment.channel.slug">
                    <img :src="comment.channel.image" width="46" height="46" class="mr-3" :alt="comment.channel.name + ' image'">
                </a>

                <div class="media-body">
                    <a :href="'/channel/' + comment.channel.slug">{{ comment.channel.name }}</a>
                    <span class="ml-2">{{ comment.created_at_humans }}</span>
                    <p>{{ comment.body }}</p>

                    <div v-for="reply in comment.replies" :key="reply.id" class="media">
                        <a :href="'/channel/' + reply.channel.slug">
                            <img :src="reply.channel.image" width="46" height="46" class="mr-3" :alt="reply.channel.name + ' image'">
                        </a>

                        <div class="media-body">
                            <a :href="'/channel/' + reply.channel.slug">{{ reply.channel.name }}</a>
                            <span class="ml-2">{{ reply.created_at_humans }}</span>
                            <p>{{ reply.body }}</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
  export default {
    props: {
      videoUid: {
        type: String,
        required: true,
      },
    },

    data() {
      return {
        comments: [],
      };
    },

    mounted() {
      this.fetchComments();
    },

    methods: {
      fetchComments() {
        axios.get(`/videos/${this.videoUid}/comments`)
          .then((response) => {
            this.comments = response.data;
          });
      },
    },
  };
</script>
