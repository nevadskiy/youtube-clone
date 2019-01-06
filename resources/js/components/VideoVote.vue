<template>
    <div class="vote">
        <button
                type="button"
                class="vote__button"
                :class="{'vote__button--active': userVote === 'up'}"
                @click="vote('up')"
        >
            <i class="vote__icon vote__icon--up"></i> {{ up }}
        </button>
        <button
                type="button"
                class="vote__button"
                :class="{'vote__button--active': userVote === 'down'}"
                @click="vote('down')"
        >
            <i class="vote__icon vote__icon--down"></i> {{ down }}
        </button>
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
        up: null,
        down: null,
        userVote: null,
        canVote: false,
      };
    },

    mounted() {
      this.getVotes();
    },

    methods: {
      getVotes() {
        axios.get(`/videos/${this.videoUid}/votes`)
          .then((response) => {
            this.up = response.data.up;
            this.down = response.data.down;
            this.userVote = response.data.user_vote;
            this.canVote = response.data.can_vote;
          })
      },

      vote(type) {
        if (!this.canVote) {
          return;
        }

        if (this.userVote === type) {
          this[type]--;
          this.userVote = null;
          this.deleteVote();
          return;
        }

        if (this.userVote) {
          this[type === 'up' ? 'down' : 'up']--;
        }

        this[type]++;
        this.userVote = type;
        this.createVote(type);
      },

      deleteVote() {
        axios.delete(`/videos/${this.videoUid}/votes`)
      },

      createVote(type) {
        axios.post(`/videos/${this.videoUid}/votes`, {type})
      },
    },
  };
</script>