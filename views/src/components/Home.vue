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
              <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item :to="{ path: '/' }">root</el-breadcrumb-item>
              </el-breadcrumb>
              <el-menu mode="horizontal" class="el-menu-horizontal-actions">
                <el-submenu index="1">
                  <template slot="title">
                    <i class="el-icon-upload"></i>
                    <span slot="title">New</span>
                  </template>
                  <el-menu-item index="1-1" @click="onCreateFolder">Create Folder</el-menu-item>
                  <el-menu-item index="1-2">Upload File/s</el-menu-item>
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

export default {
  computed: {
    ...mapGetters({
      allFilesMarked: "allFilesMarked",
      allFoldersMarked: "allFoldersMarked",
      currentFolderID: "currentFolderID",
      newFolderDigLoaded: "newFolderDigLoaded",
      totalItemsSelected: "totalMarkEntities",
      totalItems: "totalEntities",
      parentFolderId: "parentFolderId"
    })
  },
  data() {
    return {
      onDeleteSelectionConfirm: false,
      activeMenuSelectedIndex: "1"
    };
  },
  components: {
    GridView,
    NewFolder
  },
  methods: {
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
    onUploadFiles() {}
  }
};
</script>

<style type="postcss" scoped>
.el-menu-item.is-active {
  color: inherit;
}
</style>
