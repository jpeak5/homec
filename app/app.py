from flask import Flask
from flask import render_template
from flask_pymongo import PyMongo
from pprint import pprint

app = Flask(__name__)
app.config["MONGO_URI"] = "mongodb://localhost:27017/test_database"
mongo = PyMongo(app)


@app.route("/")
def home_page():
    online_users = mongo.db.users.find({"online": True})
    return render_template("index.html",
        online_users=online_users)


@app.route('/hello/')
@app.route('/hello/<name>')
def hello(name=None):
    return render_template('hello.html', name=name)


@app.route("/data/")
def data_page():
    posts = mongo.db.posts.find()
    return render_template("posts.html", posts=posts)
