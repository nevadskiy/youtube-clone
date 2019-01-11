<template>
    <div>
        {{ subscribers }} {{ subscribers === 1 ? 'subscriber' : 'subscribers' }}
        <button
                v-if="canSubscribe"
                type="button"
                class="btn btn-primary btn-sm"
                @click.prevent="subscribeHandler"
        >{{ userSubscribed ? 'Unsubscribe' : 'Subscribe' }}</button>
    </div>
</template>

<script>
  export default {
    props: {
      channelSlug: {
        type: String,
        required: true,
      },
    },

    data() {
      return {
        subscribers: null,
        userSubscribed: false,
        canSubscribe: false,
      };
    },

    mounted() {
      this.fetchSubscriptions();
    },

    methods: {
      fetchSubscriptions() {
        axios.get(`/subscription/${this.channelSlug}`)
          .then((response) => {
            this.subscribers = response.data.count;
            this.userSubscribed = response.data.user_subscribed;
            this.canSubscribe = response.data.can_subscribe;
          })
      },

      subscribeHandler() {
        if (!this.userSubscribed) {
          this.unsubscribe();
        } else {
          this.subscribe();
        }
      },

      unsubscribe() {
        this.userSubscribed = false;
        this.subscribers--;
        axios.delete(`/subscription/${this.channelSlug}`)
      },

      subscribe() {
        this.userSubscribed = true;
        this.subscribers++;
        axios.post(`/subscription/${this.channelSlug}`)
      },
    },
  };
</script>