<template>
    <div>
        <div v-if="$root.user.auth" class="video-comment">
            <div class="form-group">
                <textarea
                        v-model="body"
                        class="form-control video-comment__input"
                        placeholder="Say something"
                        required
                ></textarea>
            </div>

            <div class="d-flex">
                <div class="ml-auto">
                    <button type="submit" class="btn btn-primary" @click.prevent="createComment">Post</button>
                </div>
            </div>
        </div>

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

                    <div v-if="$root.user.auth" class="d-flex">
                        <a href="javascript:void(0);" @click="toggleReplyForm(comment.id)">Toggle reply</a>
                        <a
                                v-if="$root.user.id === comment.user_id"
                                href="javascript:void(0);"
                                @click="deleteComment(comment.id)"
                                class="ml-4"
                        >Delete</a>
                    </div>

                    <div v-show="replyFormVisible === comment.id" class="reply">
                        <div class="form-group">
                            <textarea
                                    v-model="replyBody"
                                    class="form-control video-comment__input"
                                    placeholder="Reply"
                                    required
                            ></textarea>
                        </div>

                        <div class="d-flex">
                            <div class="ml-auto">
                                <button type="submit" class="btn btn-info" @click="createReply(comment)">Post</button>
                            </div>
                        </div>
                    </div>

                    <div v-for="reply in comment.replies" :key="reply.id" class="media">
                        <a :href="'/channel/' + reply.channel.slug">
                            <img :src="reply.channel.image" width="46" height="46" class="mr-3" :alt="reply.channel.name + ' image'">
                        </a>

                        <div class="media-body">
                            <a :href="'/channel/' + reply.channel.slug">{{ reply.channel.name }}</a>
                            <span class="ml-2">{{ reply.created_at_humans }}</span>
                            <p>{{ reply.body }}</p>

                            <a
                                    v-if="$root.user.id === comment.user_id"
                                    href="javascript:void(0);"
                                    @click="deleteComment(reply.id)"
                            >Delete</a>
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
        body: '',
        replyBody: '',
        replyFormVisible: null,
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

      toggleReplyForm(commentId) {
        if (this.replyFormVisible === commentId) {
          this.replyFormVisible = null;
          return;
        }

        this.replyFormVisible = commentId;
      },

      createComment() {
        axios.post(`/videos/${this.videoUid}/comments`, {
          body: this.body,
        })
          .then((response) => {
            this.comments.unshift(response.data);
            this.body = '';
          })
          .catch((error) => {
            console.log(error);
          });
      },

      createReply(comment) {
        axios.post(`/videos/${this.videoUid}/comments`, {
          body: this.replyBody,
          reply_id: comment.id,
        })
          .then((response) => {
            comment.replies.push(response.data);
            this.replyBody = null;
            this.replyFormVisible = null;
          })
          .catch((error) => {
            console.log(error);
          });
      },

      deleteComment(commentId) {
        if (!confirm('Are you sure you want to delete this comment?')) {
          return;
        }

        this.comments.forEach((comment, index) => {
            if (comment.id === commentId) {
              this.comments.splice(index, 1);
              return;
            }

            comment.replies.forEach((reply, replyIndex) => {
                if (reply.id === commentId) {
                    this.comments[index].replies.splice(replyIndex, 1);
                    return;
                }
            })
        });

        axios.delete(`/videos/${this.videoUid}/comments/${commentId}`)
      }
    },
  };
</script>
