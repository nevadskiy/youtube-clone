<template>
    <video
            id="video"
            class="video-js vjs-fluid vjs-16-9"
            controls
            preload="auto"
            data-setup="{}"
            :poster="thumbnailUrl"
    >
        <source :src="videoUrl" type='video/mp4'>
    </video>
</template>

<script>
  import videojs from 'video.js';

  export default {
    props: {
      videoUid: {
        type: String,
        required: true,
      },
      videoUrl: {
        type: String,
        required: true,
      },
      thumbnailUrl: {
        type: String,
        required: true,
      },
    },

    data() {
      return {
        player: null,
        duration: 0,
      }
    },

    mounted() {
      this.player = videojs('video');

      this.player.on('loadedmetadata', () => {
        this.duration = Math.round(this.player.duration());
      });

      setInterval(() => {
        if (this.hasHitQuotaView()) {
          this.createView();
        }
      }, 1000)
    },

    methods: {
      // TODO: refactor it with a played() method (for case if user skip forward time hit point)
      hasHitQuotaView() {
        if (!this.duration) {
          return false;
        }

        return Math.round(this.player.currentTime()) === Math.round((10 * this.duration) / 100);
      },

      createView() {
        axios.post(`/videos/${this.videoUid}/views`)
      }
    }
  }
</script>