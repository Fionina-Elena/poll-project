<template>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Создание опроса</h1>

    <div class="mb-3">
      <label class="form-label">Название опроса</label>
      <input v-model="title" type="text" class="form-control" placeholder="Введите название...">
    </div>

    <div class="mb-3" v-for="(option, index) in options" :key="index">
      <label class="form-label">Вариант {{ index + 1 }}</label>
      <input v-model="options[index]" type="text" class="form-control" placeholder="Текст варианта...">
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
      <button @click="addOption" class="btn btn-secondary me-md-2" :disabled="options.length >= 4">
        Добавить вариант ({{ options.length }}/4)
      </button>

      <button @click="createPoll" class="btn btn-primary">
        Создать опрос
      </button>
    </div>

    <div v-if="error" class="alert alert-danger mt-3">
      {{ error }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreatePoll',

  data: function () {
    return {
      title: '',
      options: ['', ''],
      error: null
    }
  },

  methods: {
    addOption: function () {
      if (this.options.length < 4) {
        this.options.push('');
      }
    },

    createPoll: function () {
      let vue = this;
      vue.error = null;
      vue.$store.dispatch('createPoll', {
        title: vue.title,
        options: vue.options
      })
        .then(function (shortCode) {
          vue.$router.push('/poll/' + shortCode);
        })
        .catch(function () {
          vue.error = vue.$store.state.error;
        });
    }
  }
}
</script>

<style scoped>
.container {
  max-width: 600px;
}
</style>