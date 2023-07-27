<script setup lang="ts">
    import { ref, onMounted, computed, defineProps } from 'vue'
    import Pusher from 'pusher-js'
    import axios from 'axios'

    const props = defineProps({
        userId: String
    })

    const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY as string, {
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER as string,
        forceTLS: true
    })
    const channelName = `user-${props.userId}-current`;
    const channel = pusher.subscribe(channelName)
    const data = ref({})
    const intervalId = ref<number | undefined>(undefined)

    const visibleData = computed(() => {
        return data.value
    })

    channel.bind('current-weather-read', function(data: any) {
        console.log(data)
    })

    const fetchWeather = async () => {
        const response = await axios.get(`http://localhost/current/${props.userId}`);

        console.log(response.data)

        data.value = "current weather";
    }

    const startInterval = () => {
        intervalId.value = setInterval(fetchWeather, 60000) // once a min
    }

    onMounted(() => {
        fetchWeather();
        startInterval();
    })
</script>

<template>
    <div>{{ visibleData }}</div>
</template>