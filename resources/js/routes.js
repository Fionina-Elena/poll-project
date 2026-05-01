import { createRouter, createWebHistory } from 'vue-router';
import CreatePoll from "./components/CreatePoll.vue";
import VotePoll from "./components/VotePoll.vue";

export const routes = [
    { path: '/', redirect: '/create'},
    { path: "/create", component: CreatePoll },
    { path: "/poll/:code", component: VotePoll, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export { router };
