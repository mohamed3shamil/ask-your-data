from flask import Flask, request, jsonify
import pandas as pd
import ollama
import os
from werkzeug.utils import secure_filename

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = 'uploads'
os.makedirs(app.config['UPLOAD_FOLDER'], exist_ok=True)

# 📋 Schema for built-in datasets with improved prompt
def generate_schema_for(dataset):
    if dataset == "students":
        return """
You are a backend AI that converts user questions into MySQL queries.

Table: `students`
Columns:
- id (INT)
- name (VARCHAR)
- batch (VARCHAR)
- fees_paid (DECIMAL)
- due_date (DATE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

Guidelines:
- Return ONLY the SQL query (no explanations, formatting, or markdown).
- If user asks for specific columns, select only those columns.
- Do not use SELECT * unless explicitly requested.
"""
    elif dataset == "employees":
        return """
You are a backend AI that converts user questions into MySQL queries.

Table: `employees`
Columns:
- id (INT)
- name (VARCHAR)
- department (VARCHAR)
- salary (DECIMAL)
- hire_date (DATE)

Guidelines:
- Return ONLY the SQL query (no explanations, formatting, or markdown).
- If user asks for specific columns, select only those columns.
- Do not use SELECT * unless explicitly requested.
"""
    elif dataset == "sales":
        return """
You are a backend AI that converts user questions into MySQL queries.

Table: `sales`
Columns:
- id (INT)
- product (VARCHAR)
- quantity (INT)
- total_price (DECIMAL)
- sale_date (DATE)

Guidelines:
- Return ONLY the SQL query (no explanations, formatting, or markdown).
- If user asks for specific columns, select only those columns.
- Do not use SELECT * unless explicitly requested.
"""
    else:
        return "Unsupported dataset."

# 🔧 For dynamic uploaded datasets
def generate_schema_from_df(df):
    schema_lines = [f"- {col} ({str(dtype)})" for col, dtype in zip(df.columns, df.dtypes)]
    return "\n".join(schema_lines)

# 🧠 LLM query handler (built-in datasets)
@app.route("/query", methods=["POST"])
def query_sql():
    try:
        data = request.get_json()
        question = data.get("question", "").strip()
        dataset = data.get("dataset", "students").strip().lower()

        if not question:
            return jsonify({"error": "Missing 'question' in request body."}), 400

        schema_description = generate_schema_for(dataset)

        if "Unsupported" in schema_description:
            return jsonify({"error": "Unsupported dataset provided."}), 400

        response = ollama.chat(
            model="llama3",
            messages=[
                {"role": "system", "content": schema_description},
                {"role": "user", "content": question}
            ]
        )

        sql = response.get("message", {}).get("content", "").replace("```sql", "").replace("```", "").strip()
        return jsonify({"sql": sql})

    except Exception as e:
        return jsonify({"error": str(e)}), 500

# 📂 Upload file and generate SQL dynamically
@app.route("/upload", methods=["POST"])
def upload_and_query():
    try:
        file = request.files.get("file")
        question = request.form.get("question", "").strip()

        if not file or not question:
            return jsonify({"error": "Both 'file' and 'question' are required."}), 400

        filename = secure_filename(file.filename)
        filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        file.save(filepath)

        # Read CSV or Excel
        if filename.endswith(".csv"):
            df = pd.read_csv(filepath)
        elif filename.endswith((".xls", ".xlsx")):
            df = pd.read_excel(filepath)
        else:
            return jsonify({"error": "Only CSV or Excel files are supported."}), 400

        schema_prompt = f"""
You are a backend AI that converts user questions into MySQL queries.

Table: `uploaded_data`
Columns:
{generate_schema_from_df(df)}

Guidelines:
- Return ONLY the SQL query (no explanations, formatting, or markdown).
- If user asks for specific columns, select only those columns.
- Do not use SELECT * unless explicitly requested.
"""

        response = ollama.chat(
            model="llama3",
            messages=[
                {"role": "system", "content": schema_prompt},
                {"role": "user", "content": question}
            ]
        )

        sql = response.get("message", {}).get("content", "").strip().replace("```sql", "").replace("```", "")

        return jsonify({
            "sql": sql,
            "columns": list(df.columns),
            "preview": df.head(5).to_dict(orient="records")
        })

    except Exception as e:
        return jsonify({"error": str(e)}), 500

# ✅ Root endpoint
@app.route("/")
def root():
    return "✅ Ask Your Data API is running. Use `/query` or `/upload`."

if __name__ == "__main__":
    app.run(debug=True)
