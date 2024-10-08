# Game Website Analytics & Monitoring

## Overview

This project is a simple data collection and visualization tool built with Laravel (backend) and Vue.js (frontend). It fetches online user metrics from a third-party API, stores the data in an SQLite database, and provides a web interface for visualizing the data. Three metrics are on the page, currennt live user count, past 24 hours actual live users at timestamp and summary stats for past 7 days tracked data.

<img src="./homepage.png" alt="Homepage Screenshot"  height="500">

## Prerequisites

Ensure you have the following installed:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- [Vue](https://vuejs.org/guide/quick-start)
- [Vue Chartkick](https://chartkick.com/vue)

<table>
  <tr>
    <td><img src="https://picperf.io/https://laravelnews.s3.amazonaws.com/images/laravel-featured.png" alt="laravel" height="100" width="170"></td>
    <td><img src="https://miro.medium.com/v2/resize:fit:500/1*CPDIH8BWrGipHRJ6o6E2Vw.png" alt="vue" height="100" width="170"></td>
    <td><img src="https://blog.codewithdan.com/wp-content/uploads/2023/06/Docker-Logo.png" height="100" width="170"></td>
    <td> <img src="https://miro.medium.com/v2/resize:fit:1200/1*fMPUMki182HzyVZvo_awDw.png" height="100" width="170"></td>
  </tr>
</table>

## Installation

1. **Clone the Repository**

   ```
   bash git clone https://github.com/mkhanyisig/Gamefam-Analytics.git
   cd game-analytics
   ```

2. **Build and Start the Containers**

   If have noot ran migrations yet, do so

   ```
   php artisan migrate
   ```

   Start up App container services

   ```
   docker-compose up --build
   ```

   On a new tab, navigate and start the Vue frontend locally as well

   ```
   npm run dev
   ```

   This command builds the main Docker images and starts the containers for both the sail Docker image, Vue frontend and the Cron Job chedule runner.

## Running the Application

1. **Access the Application**

- Frontend (Vue.js): http://localhost:5174 (container) | http://localhost:5174 (5174)
- Backend (Laravel API): http://localhost:80 (container) | http://localhost:8000 (local machine when serving)

The Vue.js frontend will connect to the Laravel backend automatically.

2. **Scheduled Tasks**

The backend Cron job container fetches data from the external API every 10 minutes and updates the DB. This is managed through Laravel's scheduler.

## Viewing the Homepage

Navigate to (http://localhost:80) to view the homepage. The page includes:

Header: Displays the site title and a live counter of online users.
Chart: A Highcharts line chart showing online user metrics for the past 24 hours with controls to view more data. Includes export functionality to CSV.
Table: Displays user metrics for up to 7 days with columns for Date, Peak Users, and Average Users.

To run commands on the App container, especially the PHP Laravel backend service containers, either the laravel_sail_app_backend or cron-schedulework should work as specificatioon on the docker-compose command since those run the PHP BE services cruicial to App Acceptance Critera for design. This allows you to run commands on the container within terminal. The Vue Frontend terminal can be accessed simiilarily as well

## API Endpoints

- **GET** `/online-users/live`: Fetch the latest live user count stored on DB
- **GET** `/online-users/chart`: Fetch user count data for the past 24 hours.
- **GET** `/online-users/table`: Fetch summary data (peak and average users) for the past 7 days.

## Viewing SQLite Data

The SQLite database file is located in the Laravel backend container. To access and view it:

1. **Access SQLite Database**

```
 docker-compose exec laravel_sail_app_backend sh
  sqlite3 database/database.sqlite
```

2. **View Data**
   Use SQLite commands to explore the database. There is only one table for this project, the "online_users" table. \n
   Example command

```
 .tables
SELECT * FROM online_users LIMIT 10;
```

The table and application data can also be explored through using Artisan Tinker. Inside Tinker, you can run Eloquent queries to inspect the data:

```
 php artisan tinker

 App\Models\OnlineUser::all();
```

This will return all records from the online_users table, allowing you to verify that the seeding was successful.

## Resetting and Seeding Database

To populate the database with some initial data, you can use Laravel's seeder functionality.

```
docker-compose exec laravel_sail_app_backend php artisan db:seed
```

## Running Tests

Invoke tests on container via:

```
 docker-compose exec laravel_sail_app_backend php artisan test
```

## Troubleshooting

- **Containers not starting**: Ensure Docker is running and you've allocated sufficient resources.
- **Database errors**: Run `php artisan migrate --force` to ensure your database is up to date.
- **Frontend not loading**: Verify Vue.js is running on the correct port (`localhost:5174`).
