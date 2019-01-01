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

                        <div class="alert alert-danger" v-if="failed">Something went wrong. Please try again.</div>

                        <div id="video-form" v-if="uploading && !failed">
                            <div class="alert alert-info" v-if="!uploadComplete">
                                Your will be available at <a :href="videoUrl" v-text="videoUrl"></a>
                            </div>
                            <div class="alert alert-success" v-if="uploadComplete">
                                Upload complete. Video is now processing. <a href="/videos">Go to your videos</a>
                            </div>

                            <div class="progress" v-if="!uploadComplete">
                                <div class="progress-bar" role="progressbar"
                                     :style="{width: uploadProgress + '%'}"></div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" class="form-control" v-model="title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" v-model="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select id="visibility" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <button class="btn btn-primary" type="submit" @click.prevent="update">Save changes</button>
                            <span class="text-muted">{{ saveStatus }}</span>
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
        uid: null,

        file: null,
        uploading: false,
        uploadComplete: false,
        uploadProgress: 0,

        title: 'Untitled',
        description: '',
        visibility: 'private',

        saveStatus: null,

        failed: false,
      }
    },

    computed: {
      videoUrl() {
        return this.$root.url + '/videos/' + this.uid;
      },
    },

    methods: {
      fileInputChange() {
        this.uploading = true;

        this.file = document.getElementById('video').files[0];

        this.store().then(() => {
          const form = new FormData();

          form.append('video', this.file);
          form.append('uid', this.uid);

          axios.post('/upload', form, {
            onUploadProgress: event => this.updateUploadProgress(event),
          }).then(() => {
            this.uploadComplete = true;
          }).catch(() => {
            this.failed = true;
          });
        }).catch(() => {
          this.failed = true;
        })
        // store meta data
        // upload video
      },

      updateUploadProgress(event) {
        this.uploadProgress = Math.round(event.loaded * 100 / event.total);
      },

      store() {
        return axios.post('/videos', {
          title: this.title,
          description: this.description,
          visibility: this.visibility,
          extension: this.file.name.split('.').pop(),
        }).then((response) => {
          this.uid = response.data.data.uid;
        });
      },

      update() {
        this.saveStatus = 'Saving changes';

        return axios.put(`/videos/${this.uid}`, {
          title: this.title,
          description: this.description,
          visibility: this.visibility,
        }).then(() => {
          this.saveStatus = 'Changes saved';

          setTimeout(() => {
            this.saveStatus = null;
          }, 3000);
        }).catch(() => {
          this.saveStatus = 'Failed to save changes';
        });
      },

      attachBrowserExitWarning() {
        window.onbeforeunload = () => {
          if (this.uploadProcess()) {
            return 'Are you sure you want to navigate away?';
          }
        }
      },

      uploadProcess() {
        return this.uploading && !this.uploadComplete && !this.failed;
      },
    },

    mounted() {
      this.attachBrowserExitWarning();
    },
  };
</script>
