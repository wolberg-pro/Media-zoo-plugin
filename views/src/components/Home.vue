<template>
  <div class="content-page">
    <el-row>
      <el-col :span="24">
        <div class="flex flex-col bg-gray-200">
          <div class="nav-page px-4 py-2 m-2">
            <el-menu mode="horizontal" class="el-menu-horizontal-actions">
              <el-menu-item index="1" disabled>
                <div
                  class="flex flex-col-reverse divide-y divide-y-reverse divide-gray-900 mt-3 items-center w-20"
                >
                  <div
                    class="text-center text-xs leading-tight h-6 text-blue-700"
                  >{{this.totalItemsSelected}} Selected</div>
                  <div
                    class="text-center text-xs leading-tight h-6 text-blue-700"
                  >{{this.totalItems}} Items</div>
                </div>
              </el-menu-item>
              <el-submenu index="2">
                <template slot="title">Selection Tools</template>
                <el-menu-item index="2-1" @click="onMarkSelectAll()">Select all</el-menu-item>
                <el-menu-item
                  index="2-2"
                  @click="onClearSelection()"
                  :disabled="totalItemsSelected > 0"
                >Clear Selection</el-menu-item>
              </el-submenu>
              <el-menu-item index="3" @click="onDeleteSelectionConfirm = true">
                <i class="el-icon-picture-outline"></i>
                <span slot="title">Delete Media</span>
              </el-menu-item>
            </el-menu>
          </div>
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>Media Zoo Assest Control</span>
            </div>
            <div class="actions px-4 py-2 m-2">
              <nav class="bg-grey-light p-3 rounded font-sans w-full m-4">
                <ol class="list-reset flex text-grey-dark">
                  <li>
                    <a
                      href="javascript:void(0)"
                      class="text-blue font-bold"
                      @click="onRootFolderPath()"
                    >root</a>
                  </li>
                  <template v-for="(item, index) in folderLocation">
                    <li>
                      <span class="mx-2">/</span>
                    </li>
                    <li>
                      <a
                        href="javascript:void(0)"
                        class="text-blue font-bold"
                        @click="onFolderPath(item.id, index)"
                      >{{item.name}}</a>
                    </li>
                  </template>
                </ol>
              </nav>
              <el-menu mode="horizontal" class="el-menu-horizontal-actions">
                <el-submenu index="1">
                  <template slot="title">
                    <i class="el-icon-upload"></i>
                    <span slot="title">New</span>
                  </template>
                  <el-menu-item index="1-1" @click="onCreateFolder">Create Folder</el-menu-item>
                  <el-menu-item index="1-2" @click="onUploadFiles()">Upload File/s</el-menu-item>
                </el-submenu>
              </el-menu>
              <div class="nav-page px-4 py-2 m-2">
                <el-row>
                  <el-col :span="24">
                    <GridView />
                  </el-col>
                </el-row>
              </div>
            </div>
          </el-card>
        </div>
      </el-col>
    </el-row>
    <el-dialog title="Warning" :visible.sync="onDeleteSelectionConfirm" width="30%" center>
      <span>Are You sure you wise delete the folders/files</span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="onDeleteSelectionConfirm = false">Cancel</el-button>
        <el-button type="primary" @click="onDeleteSelection()">Confirm</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="Upload New File"
      :visible.sync="uploadFileIndicatorDialog"
      :show-close="false"
      width="50%"
      center
    >
      <el-form ref="form" :model="form" label-width="120px" v-if="!uploadFileIndicator">
        <el-form-item label="File" prop="file">
          <el-upload
            class="upload-file"
            drag
            :action="fileUploadUrl"
            :auto-upload="false"
            ref="upload"
            :on-change="handleUploadChange"
            :file-list="fileList"
            list-type="picture"
            :on-success="handleSuccess"
          >
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">
              Drop file here or
              <em>click to upload</em>
            </div>
          </el-upload>
        </el-form-item>
        <el-form-item label="Media Name" prop="name" required>
          <el-input
            placeholder="Name input"
            v-model="form.name"
            maxlength="100"
            minlength="3"
            show-word-limit
          ></el-input>
        </el-form-item>
        <el-form-item label="Media Alt" prop="alt">
          <el-input
            placeholder="Alt input"
            v-model="form.alt"
            maxlength="50"
            minlength="3"
            show-word-limit
          ></el-input>
        </el-form-item>

        <el-form-item label="caption" prop="caption">
          <el-input
            placeholder="Media Caption input"
            v-model="form.caption"
            maxlength="50"
            minlength="3"
            show-word-limit
          ></el-input>
        </el-form-item>

        <el-form-item label="Description" prop="description">
          <el-input
            type="textarea"
            placeholder="Media Description input"
            v-model="form.description"
          ></el-input>
        </el-form-item>
      </el-form>
      <div class="flex content-start flex-no-wrap" v-else>
        <div class="w-1/3 p-2">&nbsp;</div>
        <div>
          <el-progress type="dashboard" :percentage="uploadFileProcess" :color="colors"></el-progress>
        </div>
        <div class="w-1/3 p-2">&nbsp;</div>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="onUploadReset()">Cancel</el-button>
        <el-button :disabled="uploadFileIndicator" type="primary" @click="onUploadSubmit()">Upload!</el-button>
      </span>
    </el-dialog>
    <el-dialog
      title="New Folder"
      center
      destroy-on-close
      :visible.sync="newFolderDigLoaded"
      @close="onCreateFolderDialogClose()"
    >
      <new-folder />
    </el-dialog>
  </div>
</template>

<script>
import GridView from "./MediaViews/GridView";
import NewFolder from "./partials/dialogs/NewFolder";
import { mapGetters } from "vuex";
import SETTINGS from "../settings";

export default {
  computed: {
    ...mapGetters({
      allFilesMarked: "allFilesMarked",
      folderLocation: "folderLocation",
      allFoldersMarked: "allFoldersMarked",
      currentFolderID: "currentFolderID",
      newFolderDigLoaded: "newFolderDigLoaded",
      totalItemsSelected: "totalMarkEntities",
      totalItems: "totalEntities",
      uploadFileProcess: "uploadFileProcess",
      uploadFileIndicator: "uploadFileIndicator",
      uploadFileIndicatorDialog: "uploadFileIndicatorDialog",
      uploadFailed: "uploadFileFailedStatus",
      uploadFailedMessage: "uploadFileFailedMessage",
      parentFolderId: "parentFolderId"
    })
  },
  data() {
    return {
      fileUploadUrl: _wp_ROOT_URL + SETTINGS.API_CORE_PATH + "files/upload",
      form: {
        description: "",
        caption: "",
        file: "",
        alt: "",
        name: ""
      },
      formRules: {
        file: {
          required: true,
          message: "Please upload Media Item"
        },
        alt: {
          min: 3,
          max: 50,
          message: "Length should be 3 to 50",
          trigger: "blur"
        },
        name: {
          required: true,
          min: 3,
          max: 100,
          message: "Length should be 3 to 100",
          trigger: "blur"
        },
        caption: {
          min: 3,
          max: 50,
          message: "Length should be 3 to 50",
          trigger: "blur"
        }
      },
      fileList: [],
      percentage: 10,
      colors: [
        { color: "#f56c6c", percentage: 20 },
        { color: "#e6a23c", percentage: 40 },
        { color: "#5cb87a", percentage: 60 },
        { color: "#1989fa", percentage: 80 },
        { color: "#6f7ad3", percentage: 100 }
      ],
      onUploadDialog: false,
      onDeleteSelectionConfirm: false,
      activeMenuSelectedIndex: "1"
    };
  },
  components: {
    GridView,
    NewFolder
  },
  methods: {
    onUploadReset() {
      if (this.$refs.upload) {
        this.$refs.upload.clearFiles();
        this.$refs["form"].resetFields();
      }
      this.$store.dispatch("triggerFileUploadDialog");
    },
    onUploadSubmit() {
      this.$refs["form"].validate(valid => {
        if (valid) {
          this.$store.dispatch("uploadFile", {
            file: this.fileList[0].raw,
            name: this.form.name,
            folder_id: null,
            alt: this.form.alt,
            caption: this.form.caption,
            description: this.form.description
          });
        } else {
          alert("not valid form");
          return false;
        }
      });
    },

    handleProgress(ev, file, fileLIst) {
      file.raw["status"] = "uploading";
    },
    handleSuccess(res, file, fileLIst) {
      this.form.file = res.url;
      file.raw["status"] = "success";
    },
    handleUploadChange(file, fileList) {
      this.fileList = fileList.slice(-1);
    },
    // handleBeforeUpload(file) {
    //   const allowedCsvMime = [
    //     'text/csv',
    //     'text/plain',
    //     'application/csv',
    //     'text/comma-separated-values',
    //     'application/excel',
    //     'application/vnd.ms-excel',
    //     'application/vnd.msexcel',
    //     'text/anytext',
    //     'application/octet-stream',
    //     'application/txt',
    //   ];
    //   if (allowedCsvMime.includes(file.type)) {
    //     return true;
    //   } else {
    //     this.$message.error(
    //       'You can only upload CSV files. No other file types are allowed'
    //     );
    //     this.fileList.pop(file);
    //   }
    onRootFolderPath() {
      this.$store.dispatch("clearFolderLocation");
    },
    onFolderPath(folder_id, index) {
      this.$store.dispatch("goToFolderLocation", { folder_id, index });
    },
    onCreateFolder() {
      this.$store.dispatch("openNewFolder", { folder_id: null });
    },
    onCreateFolderDialogClose() {
      this.$store.dispatch("closeNewFolder");
    },
    onMarkSelectAll() {
      this.$store.dispatch("markAllItemsAsMark");
      this.$forceUpdate();
    },
    onClearSelection() {
      this.$store.dispatch("clearAllMarkItems");
      this.$forceUpdate();
    },
    onDeleteSelection() {
      const file_ids = this.allFilesMarked;
      const folder_ids = this.allFoldersMarked;
      if (file_ids.length > 0 || folder_ids.length > 0) {
        this.$store.dispatch("deleteMediaItems", {
          currentFolderID: this.currentFolderID || null,
          folder_ids,
          file_ids
        });
      }
      this.onDeleteSelectionConfirm = false;
    },
    onUploadFiles() {
      this.$store.dispatch("resetFileUploadState");
      this.$store.dispatch("triggerFileUploadDialog");
      if (this.$refs.upload) {
        this.$refs.upload.clearFiles();
        this.$refs["form"].resetFields();
        this.form = {
          description: "",
          caption: "",
          file: "",
          alt: "",
          name: ""
        };
      }
    }
  }
};
</script>

<style type="postcss" scoped>
.el-menu-item.is-active {
  color: inherit;
}
</style>
