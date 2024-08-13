<template>
    <div class="container">
        <h1 class="main-title">Mkhanyisi Habbo Website Traffic Tracking Analytics</h1>
        <h2 class="section-title">Online Users Count Over Time</h2>
        <div class="live-users-container">
            <img src="https://1000logos.net/wp-content/uploads/2020/09/Habbo-Logo-2000-500x386.jpg" alt="Online Users Icon" class="live-users-image" height="100">
            <h2 class="live-count">Habbos Online: <span>{{ liveCount ?? "Loading..." }}</span></h2>
        </div>
        <div class="button-container">
            <p class="chart-title">Past 24 Hours Online Users Count</p>
            <button class="export-button" @click="exportToCSV">Export to CSV</button>
        </div>
        <line-chart 
            :data="chartData" 
            :xtitle="'Time'" 
            :ytitle="'# Online Users'" 
            :discrete="true"
            class="chart"
        ></line-chart>
        <table class="data-table">
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
                    <td>{{ Math.round(row.peak_users*10)/10 }}</td>
                    <td>{{ Math.round(row.average_users*10)/10 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { format } from 'date-fns';

const liveCount = ref("Loading...");
const chartData = ref([]);
const tableData = ref([]);

const fetchLiveCount = async () => {
    try {
        const response = await axios.get('https://origins.habbo.com/api/public/origins/users');
        liveCount.value = response.data.onlineUsers;
    } catch (error) {
        console.error("Error fetching live count:", error);
    }
};

const fetchChartData = async () => {
    try {
        const response = await axios.get('/api/online-users/chart');
        if (response.data.length > 0) {
            chartData.value = response.data.map(item => [format(new Date(item.retrieved_at), 'hh:mm a'), item.count]);
        }
    } catch (error) {
        console.error("Error fetching chart data:", error);
    }
};

const fetchTableData = async () => {
    try {
        const response = await axios.get('/api/online-users/table');
        tableData.value = response.data;
    } catch (error) {
        console.error("Error fetching table data:", error);
    }
};

const exportToCSV = () => {
    const csvRows = [];
    csvRows.push(['Retrieval Time', 'Count'].join(','));
    chartData.value.forEach(row => {
        csvRows.push([
            row.retrieved_at, 
            row.count
        ].join(','));
    });
    const csvBlob = new Blob([csvRows.join('\n')], { type: 'text/csv' });
    const csvUrl = URL.createObjectURL(csvBlob);
    const link = document.createElement('a');
    link.href = csvUrl;
    link.download = 'past_day_online_users_' + format(new Date(), 'yyyy-MM-dd') + '.csv';
    link.click();
};

onMounted(() => {
    fetchLiveCount();
    fetchChartData();
    fetchTableData();
    setInterval(fetchLiveCount, 60000);
});
</script>

<style scoped>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.live-users-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.main-title {
    font-size: 2.5em;
    text-align: center;
    color: #333;
}

.section-title {
    font-size: 2em;
    text-align: center;
    color: #555;
}

.live-count {
    font-size: 2.5em;
    text-align: center;
    color: #007BFF;
    margin-bottom: 20px;
}

.live-count span {
    font-weight: bold;
}

.chart-title {
    font-size: 1.2em;
    color: orange;
    font-weight: bold;
}

.export-button {
    padding: 10px 20px;
    font-size: 1em;
    color: #fff;
    background-color: #007BFF;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.export-button:hover {
    background-color: #0056b3;
}

.chart {
    margin: 20px auto;
    max-width: 100%;
}

.button-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px auto;
    font-size: 1em;
    color: #333;
}

.data-table th,
.data-table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.data-table th {
    background-color: #f4f4f4;
    text-align: left;
}

.data-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>
