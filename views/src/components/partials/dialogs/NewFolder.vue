<template>
  <el-card class="box-card" id="dialogNewFolder">
    <el-form
      ref="form"
      :label-position="labelPosition"
      :rules="formRules"
      :model="form"
      label-width="200px"
      :disabled="submittedForm"
    >
      <el-form-item label="Folder Name" prop="name" required>
        <el-input
          placeholder="Folder Name input"
          v-model="form.name"
          maxlength="100"
          minlength="3"
          show-word-limit
        ></el-input>
      </el-form-item>

      <el-form-item label="Folder Color" prop="color">
        <el-col :span="11">
          <el-switch
            style="display: block"
            v-model="form.hasColor"
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-text="Folder Color"
            inactive-text
          ></el-switch>
        </el-col>
        <el-col class="line" :span="2">-</el-col>
        <el-col :span="11">
          <el-color-picker v-model="form.color" :disabled="!form.hasColor" size="medium"></el-color-picker>
        </el-col>
      </el-form-item>
      <el-form-item label="Folder Description" prop="description">
        <el-input type="textarea" placeholder="Folder Description input" v-model="form.description"></el-input>
      </el-form-item>

      <el-divider content-position="left">Actions</el-divider>
      <el-form-item>
        <el-button type="primary" @click="submitForm('form')">Submit</el-button>
        <el-button @click="resetForm('form')">Reset</el-button>
      </el-form-item>
    </el-form>
  </el-card>
</template>

<script>
import { mapGetters } from "vuex";
import { Loading } from "element-ui";

export default {
  computed: {
    ...mapGetters({
      createFolderLoad: "createFolderLoad",
      currentFolderID: "currentFolderID",
      createFolderStatus: "createFolderStatus"
    })
  },
  data() {
    return {
      labelPosition: "left",
      submittedForm: false,
      loader: null,
      form: {
        name: "",
        color: "",
        hasColor: false,
        description: ""
      },
      formRules: {
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
      }
    };
  },

  created() {
    this.unwatch = this.$store.watch(
      (state, getters) => getters.createFolderLoad,
      (newValue, oldValue) => {
        if (newValue && newValue !== oldValue) {
          console.log(`Updating from ${oldValue} to ${newValue}`);
          if (this.createFolderStatus) {
            setTimeout(() => {
              if (this.loading) {
                this.loading.close();
                this.loading = null;
              }
              this.openMessage("folder created", "success", 5000);
              this.$store.dispatch("getFiles", {folder_id: this.currentFolderID});
              this.$store.dispatch("closeNewFolder");
            }, 500);
          } else {
            if (this.loading) {
              this.loading.close();
              this.loading = null;
            }
            this.openMessage(
              "Server Error when create folder please retry in 1 min",
              "error",
              5000
            );
          }
        }
      }
    );
  },
  beforeDestroy() {
    this.unwatch();
  },
  methods: {
    openMessage(message, type, duration = 3000) {
      this.$message({
        showClose: true,
        duration,
        message: message,
        type: type
      });
    },
    submitForm(formName) {
      const self = this;
      const { name, color, hasColor, description } = this.form;

      this.$refs[formName].validate(valid => {
        if (valid) {
          this.submittedForm = true;
          self.loading = Loading.service({
            target: "#dialogNewFolder",
            text: "Creating Folder Please Wait...",
            spinner: "el-icon-loading",
            background: "rgba(0, 0, 0, 0.7)"
          });
          this.$store.dispatch("createFolder", {
            folder_name: name,
            folder_color: hasColor ? color : null,
            folder_description: description,
            parent_folder_id: this.currentFolderID
          });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    }
  }
};
</script>

<style type="postcss" scoped>
</style>
