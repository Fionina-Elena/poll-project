<template>
  <div class="container mt-5">
    <div v-if="$store.state.currentPoll">
      <h1 class="text-center mb-4">{{ $store.state.currentPoll.title }}</h1>

      <div v-if="$store.state.hasVoted === false">
        <OptionList :options="$store.state.currentPoll.options" v-model="selectedOptionId" />
        <button @click="vote" :disabled="selectedOptionId === null" class="btn btn-primary mt-3">
          Проголосовать
        </button>
      </div>

      <div v-else>
        <h3>Результаты голосования:</h3>
        <ul class="list-group mt-3">
          <li v-for="result in $store.state.results" :key="result.option" class="vote">
            {{ result.option }}
            <span class="badge bg-primary rounded-pill">{{ result.count }} голосов</span>
          </li>
        </ul>

        <div class="mt-3">
          <router-link to="/create" class="btn btn-secondary">
            Создать свой опрос
          </router-link>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import OptionList from './OptionList.vue';

export default {
  name: 'VotePoll',
  components: {
    OptionList
  },

  data() {
    return {
      selectedOptionId: null
    }
  },

  mounted() {
    let vue = this;
    let shortCode = vue.$route.params.code;
    vue.$store.dispatch('fetchPoll', shortCode)
      .catch(function (error) {
        console.log(error)
      });
  },

  methods: {
    vote: function () {
      let vue = this;
      vue.$store.dispatch('vote', {
        shortCode: vue.$route.params.code,
        optionId: vue.selectedOptionId
      })
        .then(function () {
        })
        .catch(function (error) {
          console.log(error);
        });
    }
  }
}
</script>

<style scoped>
.vote {
  align-items: center;
  justify-content: space-between;
}
</style>