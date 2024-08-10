<template>
    <div>
        <h1>Mkhanyisi Gamefam test App </h1>
        <h2>Gamefam Analytics</h2>
        <h2>Live Online Users: {{ liveCount ?? ""  }}</h2>
        <chartkick :data="chartData" library="highcharts"></chartkick>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Peak Users</th>
                    <th>Average Users</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in tableData" :key="row.date">
                    <td>{{ row.date }}</td>
                    <td>{{ row.peak_users }}</td>
                    <td>{{ row.average_users }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const liveCount = ref("Loading...");
const chartData = ref([]);
const tableData = ref([]);

const fetchLiveCount = async () => {
    console.log("fetching live count");
    const response = await axios.get('https://origins.habbo.com/api/public/origins/users') // '/api/online-users/live' pull live value instead of the static value periodically saved
    console.log("raw response: "+response.data);
    console.log("number of live users: "+response.data.onlineUsers);
    liveCount.value = response.data.onlineUsers;
};

const fetchChartData = async () => {
    console.log("fetching chart data");
    const response = await axios.get('/api/online-users/chart');
    if (response.data.length === 0 || response.data === null) {
        return;
    }
    console.log("chart data: "+response.data);
    chartData.value = response.data.map(item => [item.retrieved_at, item.count]);
};

const fetchTableData = async () => {
    console.log("fetching table data");
    const response = await axios.get('/api/online-users/table');
    tableData.value = response.data;
};

onMounted(() => {
    fetchLiveCount();
    fetchChartData();
    fetchTableData();

    setInterval(fetchLiveCount, 60000); // Update live count every minute
});
</script>
