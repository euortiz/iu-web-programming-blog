# DevLog

> IU Web Programming — Portfolio Project

DevLog is a **decoupled content platform** built for the Web Programming course at IU
International University of Applied Sciences. A Vue 3 single-page application serves the
public blog, while a Laravel REST API powers content management and persistence in
PostgreSQL.

- **Frontend:** Vue 3 + Vite + Tailwind CSS 4 → `http://localhost:5173`
- **Backend:** Laravel 13 REST API → `http://localhost:8000`
- **Database:** PostgreSQL 15 (Docker container `devlog-db`)

---

## ✨ Key Features

- **Public article feed** — browse posts by recency, each card showing title, excerpt, date, and comment count.
- **Full post reading** — a dedicated article view with author/date metadata.
- **Guest comments** — visitors submit comments with a display name (no account required).
- **Protected admin panel** — a single-admin CRUD interface (create / edit / delete posts) secured with Laravel Sanctum.

---

## 🧰 Tech Stack

| Layer | Technology |
| --- | --- |
| Backend | Laravel 13 (PHP 8.3+) |
| API authentication | Laravel Sanctum (bearer tokens) |
| Frontend | Vue 3, Vite, Tailwind CSS 4 |
| HTTP client | Axios |
| Routing | Vue Router |
| Database | PostgreSQL 15 (Docker) |

---

## 📋 Prerequisites

| Tool | Version |
| --- | --- |
| PHP | 8.3+ (with `pdo_pgsql`, `mbstring`, `xml`, `curl`) |
| Composer | 2.x |
| Node.js | 20.19+ (22 LTS recommended) + npm |
| Docker | Docker Desktop (macOS / Windows) or Docker Engine (Linux / WSL2) |

---

## 🚀 Local Setup & Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd iu-web-programming-blog
```

### 2. Install backend dependencies

```bash
composer install
```

### 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

The provided `.env.example` already targets the local PostgreSQL container — no manual edits
are required for the default setup:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=devlog
DB_USERNAME=devlog
DB_PASSWORD=devlog
```

### 4. Start the PostgreSQL database container

**First run** — create and start the `devlog-db` container (PostgreSQL 15):

```bash
docker run -d \
  --name devlog-db \
  -e POSTGRES_USER=devlog \
  -e POSTGRES_PASSWORD=devlog \
  -e POSTGRES_DB=devlog \
  -p 5432:5432 \
  postgres:15
```

**Subsequent runs** — start the existing container:

```bash
docker start devlog-db
```

Stop it when you are done:

```bash
docker stop devlog-db
```

### 5. Install frontend dependencies

```bash
cd frontend
npm install
```

> The frontend SPA lives in the `frontend/` directory. By default it calls the API at
> `http://localhost:8000/api`; override this with a `VITE_API_URL` entry in
> `frontend/.env` if needed.

### 6. Run migrations and seed the database

From the project root:

```bash
cd ..
php artisan migrate --seed
```

This creates the schema and seeds the single administrator account.

### 7. Start the development servers

Open **two terminals**.

**Terminal 1 — Backend API** (project root, port 8000):

```bash
php artisan serve
```

**Terminal 2 — Frontend SPA** (`frontend/` directory, port 5173):

```bash
cd frontend
npm run dev
```

Then open:

- **Frontend:** http://localhost:5173
- **API:** http://localhost:8000/api

---

## 🔑 Default Admin Credentials

| Field | Value |
| --- | --- |
| Email | `admin@devlog.test` |
| Password | `password` |

Sign in via the **Admin** link in the navbar (or directly at http://localhost:5173/login).

---

## 📚 Documentation

For architecture diagrams, page-flow and access-boundary diagrams, UI wireframes, the
authentication scope, and the full API surface, see:

- [`docs/architecture_and_scope.md`](docs/architecture_and_scope.md)

This document includes the system architecture, the client-to-API data path, and the
single-admin authentication model, and links directly to the SVG diagrams in the
[`docs/`](docs/) directory.
