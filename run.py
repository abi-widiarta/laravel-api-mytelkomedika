from flask import Flask, jsonify, request
from pddiktipy import api

app = Flask(__name__)
student_api = api()

@app.route('/search_mahasiswa', methods=['GET'])
def search_mahasiswa():
    student_id = request.args.get('student_id')
    result = student_api.search_mahasiswa(student_id)
    return jsonify(result)

if __name__ == '__main__':
    app.run(debug=True)