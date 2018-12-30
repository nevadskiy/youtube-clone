<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">

                        <input
                                v-if="!uploading"
                                type="file"
                                name="video"
                                id="video"
                                class="form-control"
                                @change="fileInputChange"
                        >

                        <div id="video-form" v-if="uploading && !failed">
                            Form
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        uploading: false,
        uploadComplete: false,
        failed: false,
      }
    },

    methods: {
      fileInputChange() {
        this.uploading = true;

        // store meta data
        // upload video
      },
    }
  }
</script>
