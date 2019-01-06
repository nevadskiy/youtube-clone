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
      }
    },

    mounted() {
      this.player = videojs('video');
    }
  }
</script>