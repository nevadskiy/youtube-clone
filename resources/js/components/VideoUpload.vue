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
        uploading: false,
        uploadComplete: false,
        failed: false,
        title: 'Untitled',
        file: null,
        description: null,
        visibility: 'private',
        saveStatus: null,
      }
    },

    methods: {
      fileInputChange() {
        this.uploading = true;

        this.file = document.getElementById('video').files[0];

        this.store().then(() => {
          // upload the video
        })
        // store meta data
        // upload video
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
      }
    },
  };
</script>
