<template>
  <div class="options-list">
    <!-- Проходим по списку вариантов -->
    <div v-for="option in options" :key="option.id" class="form-check mb-2">
      <input type="radio" class="form-check-input" :id="'option-' + option.id" :value="option.id"
        :checked="option.id === modelValue" @change="selectOption(option.id)">
      <label class="form-check-label" :for="'option-' + option.id">
        {{ option.text }}
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OptionList',

  props: {
    options: {
      type: Array,
      required: true
    },
    modelValue: {
      type: Number,
    }
  },

  methods: {
    selectOption: function (id) {
      this.$emit('update:modelValue', id);
    }
  }
}
</script>

<style scoped>
.options-list {
  margin-top: 15px;
}

.form-check-input {
  margin-right: 8px;
}
</style>