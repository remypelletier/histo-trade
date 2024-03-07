# Histotrade

## Trading Centralization Project

**Description**

This project allows you to centralize trades made on different exchanges. You will be able to see theses trades on a chart and track your performance.

**Features**

- **Adding a broker:** Add a broker by entering its information (name, API key, etc.).
- **Trade synchronization:** Synchronize trades from brokers via their APIs.
- **Trade visualization:** Visualize trades on a graph, with filters and customization options.
- **Performance tracking:** The project allows you to track the performance of your cryptocurrency investments (P&L, gains/losses, etc.).

**Technologies**

It is developed with Symfony 6 as the backend and NextJs as the frontend. The database used is MySQL, and a Docker file (compose.yaml) allows you to create the database and a persistent volume.

- **Backend:** Symfony 6
- **Frontend:** NextJs, TailwindCss
- **Database:** MySQL
- **Docker:** Docker Compose

**Dev Installation**

1. Clone the project:

```
git clone https://github.com/remypelletier/histo-trade.git
```

2. Install the dependencies:

Inside the symfony directory

```
composer install
```

Inside the nextjs directory

```
npm install
```

3. Create a `symfony/.env.local` file and configure the environment variables (database, broker APIs, etc.).

4. Start the services:

Start the backend

```
docker-compose up -d
symfony serve
```

Start the frontend

```
npm run dev
```

5. Access the application in your web browser: `http://localhost:3000`
6. Access the API in your web browser: `http://localhost:8000/api`

**Usage**

1. Add your brokers.
2. Add your API Keys.
3. Synchronize your trades.
4. Visualize your trades and track your performance.

**Useful links**

- [https://symfony.com/](https://symfony.com/)
- [https://react.dev/](https://react.dev/)
- [https://www.mysql.com/](https://www.mysql.com/)
- [https://docs.docker.com/compose/](https://docs.docker.com/compose/)

**Disclaimer**

This project is provided for informational purposes only and under development. It does not constitute investment advice.

## Database schema

The first basic version of the database:
https://dbdiagram.io/d/db_schema_v0-1-657b6f3c56d8064ca00ee3f4
