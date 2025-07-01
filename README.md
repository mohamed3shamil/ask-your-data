# Ask Your Data

**Ask Your Data** is a lightweight web application that allows users to query structured datasets using natural language. It converts user questions into MySQL queries using a local LLM (via Ollama), and executes them against either a built-in database or an uploaded CSV/Excel file.

## Features

- Ask questions in plain English and get accurate SQL queries
- Built-in support for predefined datasets (`students`, `employees`, `sales`)
- Upload your own CSV/Excel files and run queries on them
- Clean Laravel-based frontend with Flask + Python backend
- Uses Ollama to run local LLMs (like LLaMA3) for privacy and speed
- Dynamic schema prompt generation based on uploaded data

## Technologies Used

- Laravel (PHP 8+) for the frontend and routing
- Flask (Python 3.10+) for the backend API
- Ollama for local LLM inference
- MySQL for executing database queries
- Pandas for parsing uploaded files

## Prerequisites

- PHP and Composer installed
- Python and pip installed
- MySQL server running locally
- Ollama installed and running (https://ollama.com)
- Laravel configured with `.env` and database credentials

## Setup Instructions

### Backend (Flask)
1. Install Python dependencies:
   ```bash
   pip install flask pandas werkzeug ollama

2. Start Flask server:

### Frontend (Laravel)
1. Install PHP dependencies:

2. Set up `.env` with your database configuration:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ask_your_data
DB_USERNAME=root
DB_PASSWORD=

3. Run Laravel development server:
php artisan serve

### Ollama
Start the desired LLM model:
ollama run llama3

## Usage

- Navigate to `http://localhost:8000`
- Choose "Ask a Question" to query predefined datasets
- Choose "Upload & Ask" to upload a file and query its contents
- Example questions:
  - "List students who have fees due after June"
  - "Show names and salaries of employees in Marketing"
  - "What are the sales after 2023?"

## Directory Structure

ask-your-data/
├── app.py # Flask backend
├── uploads/ # Uploaded CSV/XLSX files
├── resources/views/ # Laravel Blade views
│ ├── ask.blade.php
│ ├── upload.blade.php
│ └── results.blade.php
├── routes/web.php # Laravel routes
├── public/
└── README.md

## License

This project is for educational and internal development use. No commercial license provided.

## Author

Mohamed Shamil
