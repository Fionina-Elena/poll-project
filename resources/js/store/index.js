import { createStore } from 'vuex';
import axios from 'axios';

export default createStore({
    state() {
        return {
            currentPoll: null,
            results: [],
            hasVoted: false,
            loading: false,
            error: null
        };
    },

    mutations: {
        SET_POLL(state, pollData) {
            state.currentPoll = pollData;
        },
        SET_RESULTS(state, results) {
            state.results = results;
        },
        SET_VOTED(state, status) {
            state.hasVoted = status;
        },
        SET_LOADING(state, status) {
            state.loading = status;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        RESET_STATE(state) {
            state.currentPoll = null;
            state.results = [];
            state.hasVoted = false;
            state.error = null;
        }
    },

    actions: {
        async createPoll({ commit }, { title, options }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const response = await axios.post('/api/polls', { title, options });
                return response.data.short_code;
            } catch (error) {
                commit('SET_ERROR', error.response?.data?.message || 'Ошибка создания');
                throw error;
            } finally {
                commit('SET_LOADING', false);
            }
        },

        async fetchPoll({ commit }, shortCode) {
            commit('SET_LOADING', true);
            commit('RESET_STATE', null);
            try {
                const response = await axios.get(`/api/polls/${shortCode}`);
                commit('SET_POLL', response.data);
                if (response.data.hasVoted) {
                    commit('SET_VOTED', true);
                    commit('SET_RESULTS', response.data.results);
                }
            } catch (error) {
                commit('SET_ERROR', 'Опрос не найден');
            } finally {
                commit('SET_LOADING', false);
            }
        },

        async vote({ commit }, { shortCode, optionId }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.post(`/api/polls/${shortCode}/vote`, {
                    option_id: optionId
                });
                commit('SET_RESULTS', response.data.votes);
                commit('SET_VOTED', true);
            } catch (error) {
                if (error.response?.status === 409) {
                    commit('SET_ERROR', 'Вы уже голосовали в этом опросе');
                } else {
                    commit('SET_ERROR', 'Ошибка голосования');
                }
                throw error;
            } finally {
                commit('SET_LOADING', false);
            }
        }
    }
});
