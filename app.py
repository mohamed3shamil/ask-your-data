from flask import Flask, request, jsonify
import ollama

app = Flask(__name__)

# 🎯 Standardized prompt template for accurate SQL generation
SCHEMA_DESCRIPTION = """
You are a backend AI that converts user questions into precise MySQL queries.

The database contains a single table called `students` with the following columns:
- id (INT, primary key)
- name (VARCHAR)
- batch (VARCHAR)
- fees_paid (DECIMAL)
- due_date (DATE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

Guidelines:
- Generate ONLY valid SQL statements (MySQL-compatible).
- If user asks for specific columns, return only those columns.
- If the question is broad (e.g. "show all students"), you may use `SELECT *`.
- DO NOT add explanations, markdown, code blocks, or backticks.
- Return only the SQL query.
"""

@app.route("/query", methods=["POST"])
def query_sql():
    try:
        data = request.get_json()
        question = data.get("question", "").strip()

        if not question:
            return jsonify({"error": "Missing 'question' in request body."}), 400

        # 🧠 Generate SQL using local LLM via Ollama
        response = ollama.chat(
            model="llama3",  # Use your preferred model (llama3, mistral, etc.)
            messages=[
                {"role": "system", "content": SCHEMA_DESCRIPTION},
                {"role": "user", "content": question}
            ]
        )

        raw_output = response.get("message", {}).get("content", "").strip()

        # ✂️ Clean up unwanted formatting just in case
        sql = raw_output.replace("```sql", "").replace("```", "").strip()

        return jsonify({"sql": sql})

    except Exception as e:
        return jsonify({"error": str(e)}), 500


if __name__ == "__main__":
    app.run(debug=True)
