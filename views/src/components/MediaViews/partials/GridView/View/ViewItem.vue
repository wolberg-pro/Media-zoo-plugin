<template>
  <div
    class="h-40 divide-y divide-gray-400 relative"
    @mouseover="hover = true"
    @mouseleave="hover = false"
    :class="{ active: hover }"
  >
    <div class="absolute left-auto" v-show="hover" @click="triggerMarkMediaItem()">
      <i class="el-icon-circle-plus-outline text-6xl object-none object-center" v-if="!item.mark"></i>
      <i
        class="el-icon-circle-remove-outline text-6xl object-none object-center"
        v-if="item.mark"
      ></i>
    </div>
    <div class="flex flex-col px-4 py-2 m-2" v-if="type == 'file'" @click="previewImages(item)">
      <div class="avatar">
        <el-avatar
          v-if="isFileImage(item)"
          class="cursor-pointer"
          shape="square"
          :size="120"
          :src="item.file_thumb_url"
        ></el-avatar>
        <i v-else class="el-icon-files text-5xl"></i>
      </div>
      <div class="flex flex-col bg-gray-200">
        <div class="text-gray-700 text-justify">{{ item.title }}</div>
        <div class="text-gray-700 text-justify">{{ item.registerDateTime }}</div>
      </div>
    </div>

    <div class="flex flex-col px-4 py-2 m-2" v-else>
      <div class="avatar">
        <i class="el-icon-folder text-5xl"></i>
      </div>
      <div class="flex flex-row bg-gray-200">
        <div
          v-if="item.color&&item.color != ''"
          class="badge"
          :style="{backgroundColor: item.color}"
        >
          <div class="badge-text text-gray-700 text-justify">{{ item.name }}</div>
        </div>
        <div v-else class="badge-text text-gray-700 text-justify">{{ item.name }}</div>
      </div>
    </div>
    <i
        class="el-icon-circle-circle-check text-green-700 text-6xl object-none object-center"
        v-if="item.mark"
      ></i>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({})
  },
  props: ["item", "type"],
  data() {
    return {
      hover: false
    };
  },
  methods: {
    previewImages(item) {
      this.$store.dispatch("startPreview", {
        files: this.$store.getters.allFiles,
        item
      });
    },
    isFileImage(item) {
      return item.file_mine_type.toLowerCase().indexOf("image") != -1;
    },
    isFile(item) { return !!item.file_mine_type;},
    triggerMarkMediaItem() {
      if (!this.item.mark) {
        this.$store.dispatch("addMarkItem", {
          is_file: this.isFile(this.item),
          entity_id: this.item.id
        });
      } else {
        this.$store.dispatch("remvoeMarkItem", {
          is_file: this.isFile(this.item),
          entity_id: this.item.id
        });
      }
    }
  }
};
</script>


<style type="postcss" scoped>
.badge-text {
  margin-left: 10px;
}
.badge {
  background-color: #000;
  color: #fff;
  margin-left: 5px;
  display: inline-block;
  padding-left: 8px;
  padding-right: 8px;
  width: 15px;
  height: 15px;
  text-align: center;
}

.badge {
  border-radius: 50%;
}
.list-enter,
.list-leave-to {
  visibility: hidden;
  height: 0;
  margin: 0;
  padding: 0;
  opacity: 0;
}

.list-enter-active,
.list-leave-active {
  transition: all 0.3s;
}
</style>
